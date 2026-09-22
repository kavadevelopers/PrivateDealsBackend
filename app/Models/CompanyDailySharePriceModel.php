<?php

namespace App\Models;

use App\Helpers\FileUpDownHelper;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CompanyDailySharePriceModel extends Model
{
    use HasFactory;

    protected $table = 'company_daily_share_price';

    protected $fillable = [
        'company_id',
        'date',
        'seller',
        'price',
        'distributor_price',
        'retailer_price',
    ];

    public static function getMinPrice($companyId, $date, $field)
    {
        return self::where('company_id', $companyId)
            ->where('date', $date)
            ->where('price', '!=', 0)
            ->min($field) ?? 0;
    }

    public static function getMinPriceFromArray($companyId, $array, $field)
    {
        return self::where('company_id', $companyId)
            ->wherein('id', $array)
            ->where('price', '!=', 0)
            ->min($field) ?? 0;
    }

    public static function getPriceFluctuationAlert()
    {
        $fourteenDaysAgo = Carbon::now()->subDays(30);
        $today = Carbon::today();

        $upCompanies = [];
        $downCompanies = [];

        try {
            $companies = self::select('company_id')
                ->where('date', '>=', $fourteenDaysAgo)
                ->where('date', '<=', $today)
                ->where('retailer_price', '>', 0)
                ->distinct()
                ->pluck('company_id')
                ->toArray();

            foreach ($companies as $companyId) {
                $latestPrice = self::where('company_id', $companyId)
                    ->where('date', '<=', $today)
                    ->where('retailer_price', '>', 0)
                    ->orderBy('date', 'desc')
                    ->first();

                if (!$latestPrice) continue;

                $oldestPrice = self::where('company_id', $companyId)
                    ->where('date', '>=', $fourteenDaysAgo)
                    ->where('date', '<=', $today)
                    ->where('retailer_price', '>', 0)
                    ->orderBy('date', 'asc')
                    ->first();

                if (!$oldestPrice) continue;

                $priceDifference = $latestPrice->retailer_price - $oldestPrice->retailer_price;
                $percentageChange = ($priceDifference / $oldestPrice->retailer_price) * 100;

                if (abs($percentageChange) >= 3) {
                    $company = CompanyModel::find($companyId);

                    $fluctuationData = [
                        'company_id' => $companyId,
                        'company_name' => $company->brand_name ?? 'Unknown Company',
                        // 'company_logo' => FileUpDownHelper::get_company_logo_url($company),
                        'company_logo' => (function () use ($company) {
                            try {
                                $imageContent = Storage::disk('s3')->get($company->logo);
                                if (!empty($company->logo) && $imageContent) {
                                    return 'data:image/png;base64,' . base64_encode($imageContent);
                                }
                            } catch (Exception $e) {
                            }

                            return asset('core/placeholders/long.png');
                        })(),
                        'fluctuation_percentage' => $percentageChange,
                        'current_price' => $latestPrice->retailer_price,
                        'previous_price' => $oldestPrice->retailer_price,
                        'price_difference' => $priceDifference
                    ];

                    if ($percentageChange > 0) {
                        $upCompanies[] = $fluctuationData;
                    } else {
                        $downCompanies[] = $fluctuationData;
                    }
                }
            }

            // Sort up companies (descending) and get top 5
            usort($upCompanies, function ($a, $b) {
                return $b['fluctuation_percentage'] <=> $a['fluctuation_percentage'];
            });
            $topUpCompanies = array_slice($upCompanies, 0, 5);

            // Sort down companies (ascending) and get top 5
            usort($downCompanies, function ($a, $b) {
                return $a['fluctuation_percentage'] <=> $b['fluctuation_percentage'];
            });
            $topDownCompanies = array_slice($downCompanies, 0, 5);

            return [
                'up' => $topUpCompanies,
                'down' => $topDownCompanies
            ];
        } catch (\Exception $e) {
            return [
                'up' => [],
                'down' => []
            ];
        }
    }

    public function company()
    {
        return $this->belongsTo(CompanyModel::class, 'company_id');
    }

    public static function getTopGainersLosers(int $limit = 5): array
    {
        $ranges = [30, 60, 90, 120];
        $today  = Carbon::today();

        $up   = [];
        $down = [];

        foreach ($ranges as $days) {
            $fromDate = Carbon::now()->subDays($days);
            $latestPrices = self::query()
                ->select('company_daily_share_price.*')
                ->joinSub(
                    self::query()
                        ->select('company_id', DB::raw('MAX(date) as max_date'))
                        ->where('date', '<=', $today)
                        ->where('retailer_price', '>', 0)
                        ->groupBy('company_id'),
                    'latest',
                    fn($join) => $join
                        ->on('company_daily_share_price.company_id', '=', 'latest.company_id')
                        ->on('company_daily_share_price.date', '=', 'latest.max_date')
                )
                ->where('company_daily_share_price.retailer_price', '>', 0)
                ->get()
                ->keyBy('company_id');

            $oldestPrices = self::query()
                ->select('company_daily_share_price.*')
                ->joinSub(
                    self::query()
                        ->select('company_id', DB::raw('MIN(date) as min_date'))
                        ->whereBetween('date', [$fromDate, $today])
                        ->where('retailer_price', '>', 0)
                        ->groupBy('company_id'),
                    'oldest',
                    fn($join) => $join
                        ->on('company_daily_share_price.company_id', '=', 'oldest.company_id')
                        ->on('company_daily_share_price.date', '=', 'oldest.min_date')
                )
                ->where('company_daily_share_price.retailer_price', '>', 0)
                ->get()
                ->keyBy('company_id');

            $companyIds = $oldestPrices->keys()->all();

            if (empty($companyIds)) {
                continue;
            }

            $companies = CompanyModel::select('id', 'brand_name', 'logo', 'slug')
                ->whereIn('id', $companyIds)
                ->get()
                ->keyBy('id');

            $up   = [];
            $down = [];

            foreach ($companyIds as $companyId) {
                $latest  = $latestPrices->get($companyId);
                $oldest  = $oldestPrices->get($companyId);
                $company = $companies->get($companyId);

                if (!$latest || !$oldest || !$company || $oldest->retailer_price <= 0) {
                    continue;
                }

                $percentage = (($latest->retailer_price - $oldest->retailer_price)
                    / $oldest->retailer_price) * 100;

                if (abs($percentage) < 3) {
                    continue;
                }

                $row = [
                    'id'         => $company->id,
                    'name'       => $company->brand_name,
                    'logo'       => $company->logo,
                    'slug'       => $company->slug,
                    'percentage' => round(abs($percentage), 2),
                ];

                if ($percentage > 0) {
                    $up[] = $row;
                } else {
                    $down[] = $row;
                }
            }

            usort($up,   fn($a, $b) => $b['percentage'] <=> $a['percentage']);
            usort($down, fn($a, $b) => $b['percentage'] <=> $a['percentage']);

            if (count($up) >= $limit && count($down) >= $limit) {
                return [
                    'up'   => array_slice($up, 0, $limit),
                    'down' => array_slice($down, 0, $limit),
                ];
            }
        }

        return [
            'up'   => array_slice($up ?? [], 0, $limit),
            'down' => array_slice($down ?? [], 0, $limit),
        ];
    }
}
