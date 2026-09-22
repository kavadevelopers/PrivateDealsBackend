<?php

namespace App\Http\Controllers\Api\V2\Investor;

use App\Helpers\UtillsHelper;
use App\Http\Controllers\Controller;
use App\Models\CompanyModel;
use App\Models\CompanyPriceAlertModel;
use App\Models\InvestorModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PriceAlertController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $investor = $request->user();

        $validator = Validator::make($request->all(), [
            'company_id' => 'required'
        ]);

        if ($validator->fails()) {
            return UtillsHelper::json(0, ['message' => $validator->errors()->first()]);
        }

        $query = CompanyPriceAlertModel::with([
            'company:id,brand_name,logo,share_price,distributer_price,base_price',
        ])->where('investor_id', $investor->id);

        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        $alerts = $query->orderByDesc('created_at')->first();

        return UtillsHelper::json(1, [
            'message' => 'Price alerts',
            'data'    => $alerts,
        ]);
    }

    public function storeOrUpdate(Request $request): JsonResponse
    {
        $investor = $request->user();

        $validator = Validator::make($request->all(), [
            'company_id'    => 'required',
            'target_price'  => 'required',
            'remind_always' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return UtillsHelper::json(0, [
                'message' => $validator->errors()->first()
            ]);
        }

        $company = CompanyModel::approved()->where('is_deleted', 0)
            ->find($request->company_id);

        if (!$company) {
            return UtillsHelper::json(0, ['message' => 'Company not found']);
        }

        $currentPrice = (float) $company->share_price;
        $targetPrice  = (float) $request->target_price;

        if ($targetPrice > $currentPrice) {
            $direction = 'up';
        } else {
            $direction = 'down';
        }

        $alert = CompanyPriceAlertModel::where('investor_id', $investor->id)
            ->where('company_id', $request->company_id)
            ->first();

        $data = [
            'target_price'  => $targetPrice,
            'direction'     => $direction,
            'remind_always' => $request->boolean('remind_always'),
            'is_active'     => true,
            'is_triggered'  => false,
            'triggered_at'  => null,
        ];

        if ($alert) {
            $alert->update($data);
            $message = 'Price alert updated successfully';
        } else {
            $alert = CompanyPriceAlertModel::create(array_merge($data, [
                'investor_id' => $investor->id,
                'company_id'  => $request->company_id,
            ]));
            $message = 'Price alert created successfully';
        }

        return UtillsHelper::json(1, [
            'message' => $message,
            'data'    => $alert->load('company:id,brand_name,logo,share_price'),
        ]);
    }


    public function delete(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'company_id' => 'required'
        ]);

        if ($validator->fails()) {
            return UtillsHelper::json(0, ['message' => $validator->errors()->first()]);
        }

        $investor = $request->user();

        $alert = CompanyPriceAlertModel::where('investor_id', $investor->id)
            ->where('company_id', $request->company_id)
            ->first();

        if (!$alert) {
            return UtillsHelper::json(0, ['message' => 'Alert not found for this company']);
        }

        $alert->delete();

        return UtillsHelper::json(1, ['message' => 'Price alert deleted successfully']);
    }
}
