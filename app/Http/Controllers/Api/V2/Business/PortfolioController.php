<?php

namespace App\Http\Controllers\Api\V2\Business;

use App\Enums\InstrumentTypeEnum;
use App\Enums\PartnerTypeEnum;
use App\Enums\PreIpoCategoryEnum;
use App\Helpers\UtillsHelper;
use App\Http\Controllers\Controller;
use App\Models\InvestorModel;
use App\Models\PartnerModel;
use App\Models\PortfolioModel;
use App\Models\PortfolioPreIpoModel;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\JsonResponse;

class PortfolioController extends Controller
{
    public function startupPortfolio(Request $request): JsonResponse
    {
        if (!$request->filled('type')) {
            return UtillsHelper::json(0, ['message' => 'Type Required']);
        }

        $type = $request->input('type');
        if (!in_array($type, array_column(InstrumentTypeEnum::cases(), 'value'), true)) {
            return UtillsHelper::json(0, ['message' => 'Type Required']);
        }

        $investorIds = $this->resolveInvestorIds($request);
        if ($investorIds->isEmpty()) {
            return UtillsHelper::json(1, [
                'message' => 'Startup portfolio',
                'data' => [],
            ]);
        }

        $query = PortfolioModel::whereIn('investor_id', $investorIds)
            ->where('shares', '>', 0)
            ->where('instrument', $type)
            ->with([
                'startup.details',
                'startup.cms',
                'investor:id,uuid,name,profile_photo',
            ]);

        if ($request->filled('startup_ids')) {
            $startupIds = array_map('trim', explode(',', $request->startup_ids));
            $query->whereIn('startup_id', $startupIds);
        }

        $holdings = $query->get();

        return UtillsHelper::json(1, [
            'message' => 'Startup portfolio',
            'data' => $this->groupByInvestor($holdings, 'startup_id'),
        ]);
    }

    public function preIpoPortfolio(Request $request): JsonResponse
    {
        $investorIds = $this->resolveInvestorIds($request);
        if ($investorIds->isEmpty()) {
            return UtillsHelper::json(1, [
                'message' => 'Pre-IPO portfolio',
                'data' => [],
            ]);
        }

        $holdings = PortfolioPreIpoModel::whereIn('investor_id', $investorIds)
            ->where('shares', '>', 0)
            ->whereHas('company', function ($q) {
                $q->where(function ($q) {
                    $q->whereNull('category')
                        ->orWhere('category', '!=', PreIpoCategoryEnum::listed->value);
                });
            })
            ->with([
                'company' => fn ($q) => $q->select('id', 'brand_name', 'logo'),
                'investor:id,uuid,name,profile_photo',
            ])
            ->get()
            ->each(function ($holding) {
                $holding->company?->makeHidden([
                    'transaction',
                    'share_price',
                    'distributer_price',
                    'share_prices',
                    'base_price',
                ]);
            });

        return UtillsHelper::json(1, [
            'message' => 'Pre-IPO portfolio',
            'data' => $this->groupByInvestor($holdings, 'company_id'),
        ]);
    }

    private function resolveInvestorIds(Request $request): Collection
    {
        $partner = $request->user();
        if (!$partner instanceof PartnerModel) {
            return collect();
        }

        $partnerIds = PartnerModel::select('id')
            ->where('parent_id', $partner->id)
            ->where('type', PartnerTypeEnum::relationmanager->value)
            ->pluck('id');
        $partnerIds->push($partner->id);

        $investorIds = InvestorModel::where('is_deleted', 0)
            ->whereIn('partner_id', $partnerIds)
            ->pluck('id');

        if ($request->filled('investor_ids')) {
            $requestedIds = array_map('trim', explode(',', $request->investor_ids));
            $investorIds = $investorIds->intersect($requestedIds)->values();
        }

        return $investorIds;
    }

    private function groupByInvestor(Collection $holdings, string $entityIdColumn): array
    {
        return $holdings
            ->groupBy('investor_id')
            ->map(function (Collection $investorHoldings) use ($entityIdColumn) {
                $investor = $investorHoldings->first()->investor;

                return [
                    'investor' => [
                        'id' => $investor->id,
                        'uuid' => $investor->uuid,
                        'name' => $investor->name,
                        'profile_photo' => $investor->profile_photo,
                    ],
                    'total_company_count' => $investorHoldings->pluck($entityIdColumn)->unique()->count(),
                    'total_investment_amount' => round((float) $investorHoldings->sum('investment_amount'), 2),
                    'holdings' => $investorHoldings->values(),
                ];
            })
            ->values()
            ->all();
    }
}
