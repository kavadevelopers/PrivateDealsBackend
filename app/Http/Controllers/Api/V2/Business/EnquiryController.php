<?php

namespace App\Http\Controllers\Api\V2\Business;

use App\Enums\CompanyEnquiryStatusEnum;
use App\Enums\CompanyEnquiryTypeEnum;
use App\Enums\CompanyTypeEnum;
use App\Helpers\UtillsHelper;
use App\Http\Controllers\Controller;
use App\Models\CompanyDealModel;
use App\Models\CompanyEnquiryModel;
use App\Models\CompanyModel;
use App\Models\PartnerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

class EnquiryController extends Controller
{
    public function create(Request $request): JsonResponse
    {
        $validation = Validator::make($request->all(), [
            'enquiry_type' => 'required|in:' . implode(',', array_column(CompanyEnquiryTypeEnum::cases(), 'value')),
            'company_id' => 'required_without:company_slug|nullable|integer',
            'company_slug' => 'required_without:company_id|nullable|string',
            'deal_id' => 'nullable|integer',
            'deal_uuid' => 'nullable|uuid',
            'quantity' => 'required|integer|min:1',
            'offer_price' => 'required|numeric|min:0.01',
            'offer_valid_till' => 'nullable|date|after_or_equal:today',
            'notes' => 'nullable|string|max:2000',
        ]);

        if ($validation->fails()) {
            return UtillsHelper::json(0, ['message' => $validation->errors()->first()]);
        }

        $partner = $request->user();
        if (!$partner instanceof PartnerModel) {
            return UtillsHelper::json(0, ['message' => 'Unauthorized']);
        }

        $companyQuery = CompanyModel::approved()->where('is_deleted', 0);
        if ($request->filled('company_id')) {
            $companyQuery->where('id', $request->company_id);
        } else {
            $companyQuery->where('slug', $request->company_slug);
        }

        $company = $companyQuery->first();
        if (!$company) {
            return UtillsHelper::json(0, ['message' => 'Company not found']);
        }

        $allowedTypes = [
            CompanyTypeEnum::unlisted->value,
            CompanyTypeEnum::secondary->value,
        ];
        if (!in_array($company->type, $allowedTypes, true)) {
            return UtillsHelper::json(0, ['message' => 'Enquiry is only allowed for unlisted or secondary companies']);
        }

        $dealId = null;
        if ($request->filled('deal_id') || $request->filled('deal_uuid')) {
            $dealQuery = CompanyDealModel::query()
                ->where('company_id', $company->id)
                ->notDeleted()
                ->notExpired();

            if ($request->filled('deal_id')) {
                $dealQuery->where('id', $request->deal_id);
            } else {
                $dealQuery->where('uuid', $request->deal_uuid);
            }

            $deal = $dealQuery->first();
            if (!$deal) {
                return UtillsHelper::json(0, ['message' => 'Deal not found for this company']);
            }
            $dealId = $deal->id;
        }

        $enquiry = new CompanyEnquiryModel();
        $enquiry->company_id = $company->id;
        $enquiry->deal_id = $dealId;
        $enquiry->enquiry_type = $request->enquiry_type;
        $enquiry->user_id = $partner->id;
        $enquiry->user_type = PartnerModel::class;
        $enquiry->quantity = (int) $request->quantity;
        $enquiry->offer_price = $request->offer_price;
        $enquiry->offer_valid_till = $request->offer_valid_till;
        $enquiry->notes = $request->notes;
        $enquiry->status = CompanyEnquiryStatusEnum::pending->value;

        if (!$enquiry->save()) {
            return UtillsHelper::json(0, ['message' => 'Failed to save enquiry']);
        }

        return UtillsHelper::json(1, [
            'message' => 'Enquiry submitted successfully',
            'data' => [
                'uuid' => $enquiry->uuid,
                'enquiry_type' => $enquiry->enquiry_type instanceof CompanyEnquiryTypeEnum
                    ? $enquiry->enquiry_type->value
                    : $enquiry->enquiry_type,
                'status' => $enquiry->status instanceof CompanyEnquiryStatusEnum
                    ? $enquiry->status->value
                    : $enquiry->status,
            ],
        ]);
    }
}
