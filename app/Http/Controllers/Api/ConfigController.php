<?php

namespace App\Http\Controllers\Api;

use App\Enums\GenderEnum;
use App\Helpers\CommonHelper;
use App\Helpers\UtillsHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Enums\BankAccountTypeEnum;
use App\Enums\CouponCompanyScopeEnum;
use App\Enums\CouponTypeEnum;
use App\Enums\DocumentTypeEnum;
use App\Enums\HolidayTypeEnum;
use App\Enums\InstrumentTypeEnum;
use App\Enums\InvestorCouponStatusEnum;
use App\Enums\InvestorProfileVisibilityEnum;
use App\Enums\InvestorTypeEnum;
use App\Enums\MessagesStatusEnum;
use App\Enums\MinimumInvestmentTypeEnum;
use App\Enums\NotificationTypeEnum;
use App\Enums\PartnerTypeEnum;
use App\Enums\PaymentStatusEnum;
use App\Enums\PreIpoCategoryEnum;
use App\Enums\PrimaryTransactionPaymentMode;
use App\Enums\PrimaryTransactionStatusEnum;
use App\Enums\PrimaryTransactionTypeEnum;
use App\Enums\StartupPrimaryRoundStatusEnum;
use App\Enums\StartupRoundTypeEnum;
use App\Enums\Utills\CodeVerificationTypeEnum;
use App\Enums\Utills\CommunicationType;
use App\Enums\Utills\DeviceTypeEnum;
use App\Enums\Utills\StatusEnum;
use App\Enums\WpMessageTypeEnum;
use App\Models\AppSettingsModel;
use App\Models\AppVersionControlModel;
use App\Models\CompanyModel;
use App\Models\StartupRoundModel;

class ConfigController extends Controller
{
    function get(): JsonResponse

    {
        $request = request();
        $getconfig = [];
        $region = Config::get('filesystems.disks.s3.region');
        $bucket = Config::get('filesystems.disks.s3.bucket');
        $S3baseUrl = "https://s3-$region.amazonaws.com/$bucket/";


        $getconfig['document']['max_size']      = CommonHelper::appSettings('file_document_max_size');
        $getconfig['document']['extensions']    = CommonHelper::appSettings('file_document_extensions_allowed');
        $getconfig['image']['max_size']         = CommonHelper::appSettings('file_image_max_size');
        $getconfig['image']['extensions']       = CommonHelper::appSettings('file_image_extensions_allowed');
        $getconfig['video']['max_size']         = CommonHelper::appSettings('file_video_max_size');
        $getconfig['video']['extensions']       = CommonHelper::appSettings('file_video_extensions_allowed');
        $getconfig['investment']['primary']['aif_min_investment']       = 100000;

        $getconfig['s3-baseurl']                = $S3baseUrl;
        $getconfig['app_pagination_page_limit']     = CommonHelper::appSettings('app_pagination_limit');
        $getconfig['enum'] = [
            'gender' => UtillsHelper::enumToArray(GenderEnum::class),
            'bank_account_type' => UtillsHelper::enumToArray(BankAccountTypeEnum::class),
            'document_type' => UtillsHelper::enumToArray(DocumentTypeEnum::class),
            'instrument_type' => UtillsHelper::enumToArray(InstrumentTypeEnum::class),
            'investor_profile_visibility' => UtillsHelper::enumToArray(InvestorProfileVisibilityEnum::class),
            'investor_type' => UtillsHelper::enumToArray(InvestorTypeEnum::class),
            'messages_status' => UtillsHelper::enumToArray(MessagesStatusEnum::class),
            'notification_type' => UtillsHelper::enumToArray(NotificationTypeEnum::class),
            'partner_type' => UtillsHelper::enumToArray(PartnerTypeEnum::class),
            'payment_status' => UtillsHelper::enumToArray(PaymentStatusEnum::class),
            'primary_transaction_type' => UtillsHelper::enumToArray(PrimaryTransactionTypeEnum::class),
            'primary_transaction_payment_mode' => UtillsHelper::enumToArray(PrimaryTransactionPaymentMode::class),
            'primary_transaction_status' => UtillsHelper::enumToArray(PrimaryTransactionStatusEnum::class),
            'min_investment_type' => UtillsHelper::enumToArray(MinimumInvestmentTypeEnum::class),
            'startup_primary_round_status' => UtillsHelper::enumToArray(StartupPrimaryRoundStatusEnum::class),
            'startup_round_type' => UtillsHelper::enumToArray(StartupRoundTypeEnum::class),
            'wp_message_type' => UtillsHelper::enumToArray(WpMessageTypeEnum::class),
            'code_verification_type' => UtillsHelper::enumToArray(CodeVerificationTypeEnum::class),
            'communication_type' => UtillsHelper::enumToArray(CommunicationType::class),
            'device_type' => UtillsHelper::enumToArray(DeviceTypeEnum::class),
            'status' => UtillsHelper::enumToArray(StatusEnum::class),
            'preipo_category' => UtillsHelper::enumToArray(PreIpoCategoryEnum::class),
            'coupon_type' => UtillsHelper::enumToArray(CouponTypeEnum::class),
            'investor_coupon_status' => UtillsHelper::enumToArray(InvestorCouponStatusEnum::class),
            'holiday_type' => UtillsHelper::enumToArray(HolidayTypeEnum::class),
            'coupon_company_scope' => UtillsHelper::enumToArray(CouponCompanyScopeEnum::class),

        ];
        $getconfig['notes']                     = ['max_size provided is in mb'];
        // $getconfig['min_version']               = 1;
        // $getconfig['force_update']              = 1;
        $getconfig['current_api_version']           = 'v1';

        // $companies = CompanyModel::where('is_deleted', 0)->select('logo')->get();
        // $getconfig['landing_banner']['preipo']       = $companies->pluck('logo')->toArray();


        // $completed = StartupRoundModel::where('round_status', StartupPrimaryRoundStatusEnum::completed->value)
        //     ->with(['startup.details' => function ($query) {
        //         $query->select('startup_id', 'logo');
        //     }])
        //     ->whereHas('startup', function ($query) {
        //         $query->where('registration_step', 6);
        //     })
        //     ->groupBy('startup_id')
        //     ->get();

        // $getconfig['landing_banner']['secondary'] = $completed->map(function ($round) {
        //     return $round->startup->details->logo ?? '';
        // })->filter()->toArray();

        // $raisingNow = StartupRoundModel::where('round_status', StartupPrimaryRoundStatusEnum::raisingnow->value)
        //     ->with(['startup.details' => function ($query) {
        //         $query->select('startup_id', 'logo');
        //     }])
        //     ->whereHas('startup', function ($query) {
        //         $query->where('registration_step', 6);
        //     })
        //     ->groupBy('startup_id')
        //     ->get();
        // $comingSoon = StartupRoundModel::where('round_status', StartupPrimaryRoundStatusEnum::comingsoon->value)
        //     ->with(['startup.details' => function ($query) {
        //         $query->select('startup_id', 'logo');
        //     }])
        //     ->whereHas('startup', function ($query) {
        //         $query->where('registration_step', 6);
        //     })
        //     ->groupBy('startup_id')
        //     ->get();
        // $getconfig['landing_banner']['primary'] = collect([$raisingNow, $comingSoon])
        //     ->flatten()
        //     ->map(function ($round) {
        //         return $round->startup->details->logo ?? '';
        //     })
        //     ->filter()
        //     ->toArray();

        $completed = StartupRoundModel::where('round_status', StartupPrimaryRoundStatusEnum::completed->value)
            ->with(['startup.details' => function ($query) {
                $query->select('startup_id', 'banner');
            }])
            ->whereHas('startup', function ($query) {
                $query->where('registration_step', 6);
            })
            ->groupBy('startup_id')
            ->get();
        $preipo = CompanyModel::where('is_deleted', 0)->select('logo')->get();

        $getconfig['secondary_banners'] = $completed->map(function ($round) {
            return $round->startup->details->banner ?? '';
        })->filter()->toArray();

        $getconfig['preipo_banners'] = $preipo->pluck('logo')->toArray();

        $users = ['investor', 'distributer'];
        $getconfig['app_version'] = [];
        if ($request->has('user')) {
            $users = [$request->user];
        }
        foreach ($users as $key => $user) {
            $data = [];
            if ($request->has('device')) {
                $row = AppVersionControlModel::where('app_type', $user)->where('device', $request->device)->latest()->first();
                array_push($data, [
                    'device'            => $request->device,
                    'last_version_code' => $row->last_version_code ?? 0,
                    'current_version_code' => $row->current_version_code ?? 1,
                    'last_version' => $row->last_version ?? 0.0000,
                    'current_version' => $row->current_version ?? 0.0000,
                    'force_update' => $row->force_update ?? false,
                    'title' => $row->title ?? 'N/A',
                    'description' => $row->description ?? 'N/A',
                ]);
            } else {
                foreach (DeviceTypeEnum::cases() as $dKey => $dVal) {
                    if ($dVal->value != 'web') {
                        $row = AppVersionControlModel::where('app_type', $user)->where('device', $dVal->value)->latest()->first();
                        array_push($data, [
                            'device'            => $dVal->value,
                            'last_version_code' => $row->last_version_code ?? 0,
                            'current_version_code' => $row->current_version_code ?? 1,
                            'last_version' => $row->last_version ?? 0.0000,
                            'current_version' => $row->current_version ?? 0.0000,
                            'force_update' => $row->force_update ?? false,
                            'title' => $row->title ?? 'N/A',
                            'description' => $row->description ?? 'N/A',
                        ]);
                    }
                }
            }

            array_push($getconfig['app_version'], [
                'type'          => $user,
                'data'          => $data
            ]);
        }



        $getconfig['pre_ipo_min_sell_amount'] = 50000.00;
        $getconfig['build']['windows'] = ['investor' => 'build/windows/investor', 'distributer' => 'build/windows/distributer'];
        $getconfig['contact']['email'] = CommonHelper::appSettings('branding_content_contact_email');
        $getconfig['contact']['mobile'] = CommonHelper::appSettings('branding_content_contact_mobile');
        $getconfig['contact']['whatsapp'] = '+91 7069155545';
        $getconfig['contact']['book_slot_image'] = CommonHelper::appSettings('book_slot_image');
        $getconfig['app_tutorial_video'] = CommonHelper::appSettings('app_tutorial_video');
        $getconfig['preipo_buy_button'] = 'Check Availability';
        $getconfig['preipo_investment_buy_button'] = 'Request To Buy';
        $getconfig['kyc_type'] = [
            'ekyc' => true,
            'manual' => true,
        ];
        $getconfig['investment_process'] = [
            'title' => 'Investment Process',
            'html' => 'Enter quantity and slide to invest. | Wait up to 24 hours to verify share availability and receive confirmation. | After confirmation, a deal slip will be generated and sent to you via SMS. | Sign the deal slip and make the payment. | Share transfer will be initiated once payment is received. | Shares will be received within 24–72 hours. | Transaction completed.'
        ];

        $supportSettings = AppSettingsModel::whereIn('key', [
            'support_whatsapp_number',
            'support_email',
            'support_phone',
        ])->pluck('value', 'key');

        $getconfig['support'] = [
            // 'whatsapp_url'  => 'https://wa.me/' . $supportSettings->get('support_whatsapp_number'),
            'whatsapp_url'  => $supportSettings->get('support_whatsapp_number'),
            'email'         => $supportSettings->get('support_email'),
            'call_support'  => $supportSettings->get('support_phone'),
            'book_slot_image' => CommonHelper::appSettings('book_slot_image'),
        ];
        $getconfig['calendly_url'] = 'https://calendly.com/techshuruup/30min';

        return UtillsHelper::json(1, [
            'message' => "Config Data",
            'data' => $getconfig
        ]);
    }
}
