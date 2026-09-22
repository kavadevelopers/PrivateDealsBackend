<?php

namespace App\Http\Controllers\Api\V2\Seller;

use App\Enums\CompanyEnquiryStatusEnum;
use App\Enums\CompanyEnquiryTypeEnum;
use App\Helpers\CommonHelper;
use App\Helpers\UtillsHelper;
use App\Http\Controllers\Controller;
use App\Models\CompanyEnquiryModel;
use App\Models\SellerMasterModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SellEnquiryController extends Controller
{
    public function list(Request $request): JsonResponse
    {
        $statusValues = implode(',', array_column(CompanyEnquiryStatusEnum::cases(), 'value'));
        $validation = Validator::make($request->all(), [
            'status' => 'nullable|in:' . $statusValues,
            'company_id' => 'nullable|integer',
            'skip' => 'nullable|integer|min:0',
            'take' => 'nullable|integer|min:1',
        ]);

        if ($validation->fails()) {
            return UtillsHelper::json(0, ['message' => $validation->errors()->first()]);
        }

        $seller = $request->user();
        if (!$seller instanceof SellerMasterModel) {
            return UtillsHelper::json(0, ['message' => 'Unauthorized']);
        }

        $query = CompanyEnquiryModel::query()
            ->notDeleted()
            ->where('enquiry_type', CompanyEnquiryTypeEnum::sell->value)
            ->with([
                'company' => fn ($q) => $q->select('id', 'brand_name', 'slug', 'logo', 'type'),
                'deal' => fn ($q) => $q->select(
                    'id',
                    'uuid',
                    'company_id',
                    'deal_type',
                    'share_price',
                    'available_quantity',
                    'minimum_qty'
                ),
                'user',
            ])
            ->orderByDesc('id');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('company_id')) {
            $query->where('company_id', (int) $request->company_id);
        }

        $skip = max(0, (int) $request->input('skip', 0));
        $take = (int) $request->input('take', CommonHelper::appSettings('app_pagination_limit'));
        if ($take < 1) {
            $take = 15;
        }

        $total = (clone $query)->count();
        $enquiries = $query
            ->skip($skip)
            ->take($take)
            ->get()
            ->map(fn (CompanyEnquiryModel $enquiry) => $this->formatSellEnquiry($enquiry))
            ->values();

        return UtillsHelper::json(1, [
            'message' => 'Sell enquiry list',
            'data' => $enquiries,
            'total' => $total,
            'skip' => $skip,
            'take' => $take,
        ]);
    }

    private function formatSellEnquiry(CompanyEnquiryModel $enquiry): array
    {
        $company = $enquiry->company;
        $deal = $enquiry->deal;
        $partner = $enquiry->user;

        return [
            'uuid' => $enquiry->uuid,
            'enquiry_type' => $enquiry->enquiry_type instanceof CompanyEnquiryTypeEnum
                ? $enquiry->enquiry_type->value
                : $enquiry->enquiry_type,
            'status' => $enquiry->status instanceof CompanyEnquiryStatusEnum
                ? $enquiry->status->value
                : $enquiry->status,
            'quantity' => (int) $enquiry->quantity,
            'offer_price' => (float) $enquiry->offer_price,
            'offer_valid_till' => optional($enquiry->offer_valid_till)?->format('Y-m-d'),
            'notes' => $enquiry->notes,
            'created_at' => optional($enquiry->created_at)?->toDateTimeString(),
            'company' => $company ? [
                'id' => $company->id,
                'brand_name' => $company->brand_name,
                'slug' => $company->slug,
                'logo' => $company->logo,
                'type' => $company->type,
            ] : null,
            'deal' => $deal ? [
                'id' => $deal->id,
                'uuid' => $deal->uuid,
                'deal_type' => $deal->deal_type instanceof \BackedEnum
                    ? $deal->deal_type->value
                    : $deal->deal_type,
                'share_price' => (float) $deal->share_price,
                'available_quantity' => (int) $deal->available_quantity,
                'minimum_qty' => (int) $deal->minimum_qty,
            ] : null,
            'partner' => $partner ? [
                'id' => $partner->id,
                'name' => $partner->name ?? null,
            ] : null,
        ];
    }
}
