<?php

namespace App\Http\Controllers\Web\Front\Auth\Startup;

use App\Enums\StartupPrimaryRoundStatusEnum;
use App\Enums\StartupRoundTypeEnum;
use App\Enums\Utills\CodeVerificationTypeEnum;
use App\Helpers\AdminHelper;
use App\Helpers\FileUpDownHelper;
use App\Helpers\UtillsHelper;
use App\Http\Controllers\Controller;
use App\Models\MasterCityModel;
use App\Models\MasterSectorsModel;
use App\Models\MasterSocialmediaLinkModel;
use App\Models\StartupRoundModel;
use App\Models\ReportsVerificationCodeModel;
use App\Models\StartupDetailsModel;
use App\Models\StartupLegalModel;
use App\Models\StartupOtherDetailModel;
use App\Models\StartupDocumentModel;
use App\Models\StartupModel;
use App\Models\StartupSocialMediaModel;
use App\Models\StartupTeamModel;
use App\Models\NotificationsModel;
use App\Models\StartupFundRaiseModel;
use App\Models\StartupKeyMetricsModel;
use App\Models\StartupFinancialDetailModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;

class RegisterController extends Controller
{

    function apply(): View
    {
        setPageTitle('Apply For Raise');
        addJavascriptFile('front-assets/js/custom/auth/startup/register.js');
        return view('front.startup.auth.register.apply');
    }

    function mobilePost(Request $request): JsonResponse
    {
        $validation = Validator::make($request->all(), [
            'mobile_number' => 'required|numeric|digits:10'
        ], [], [
            'mobile_number' => 'Mobile number is required'
        ]);

        if ($validation->fails()) {
            return UtillsHelper::json(0, ['message' => $validation->errors()->first()]);
        }

        $startup = StartupModel::where('mobile_number', $request->mobile_number)
            ->where('is_deleted', '0')->first();
        if (!$startup) {
            $startup = new StartupModel();
            $startup->mobile_number = $request->mobile_number;
            $startup->save();
        }

        UtillsHelper::sendVerificationCode($startup->id, StartupModel::class, $request->mobile_number, CodeVerificationTypeEnum::register);
        Session::put('startup_register_id', $startup->id);

        return UtillsHelper::json(1, ['view' => view('front.common.auth.verifyotp', [
            'mobile_no' => $request->mobile_number,
            'form_route' => route('front.raise.auth.post.register.verifyotp'),
            'resend_route' => route('front.raise.auth.post.register.resendotp')
        ])->render()]);
    }

    function setPassword(Request $request): JsonResponse
    {
        if (!Session::has('startup_register_id')) {
            return UtillsHelper::json(0, ['reset' => true]);
        }

        $startup = StartupModel::where('id', Session::get('startup_register_id'))->first();
        if (!$startup) {
            return UtillsHelper::json(0, ['reset' => true]);
        } else {
            $validation = Validator::make($request->all(), [
                'password'  => 'required',
                'cpassword' => 'required'
            ], [], [
                'password'                                  => 'Password is required',
                'cpassword'                                 => 'Confirm Password is required'
            ]);

            if ($validation->fails()) {
                return UtillsHelper::json(0, ['message' => $validation->errors()->first()]);
            }

            $startup->password = Hash::make($request->password);
            $startup->save();

            return self::handleResponse($startup);
        }
    }

    function detailsPost(Request $request)
    {
        if (!Session::has('startup_register_id')) {
            return UtillsHelper::json(0, ['reset' => true]);
        }

        $validation = Validator::make($request->all(), [
            'company_name' => 'required|max:255',
            'brand_name' => 'required|max:255',
            'brief_description' => 'required',
            'registered_address' => 'required',
            // 'country_id' => 'required',
            // 'state_id' => 'required',
            // 'city_id' => 'required',
            'email' => 'required|email',
            // 'industry_segment' => 'required',
            // 'sector_id' => 'required'
        ], [], [
            'company_name' => 'Company name is required',
            'brand_name' => 'Brand name is required',
            'brief_description' => 'Brief description is required',
            'registered_address' => 'Registered address is required',
            // 'country_id' => 'Country is required',
            // 'state_id' => 'State is required',
            // 'city_id' => 'City is required',
            'email' => 'Email is required',
            // 'industry_segment' => 'Industry is required',
            // 'sector_id' => 'Sector is required',
        ]);


        if ($validation->fails()) {
            return UtillsHelper::json(0, ['message' => $validation->errors()->first()]);
        }

        $startup = StartupModel::where('id', Session::get('startup_register_id'))->first();
        if (!$startup) {
            return UtillsHelper::json(0, ['reset' => true]);
        } else {

            $startup->url_slug = AdminHelper::startupSlug($request->input('brand_name'));
            $startup->brand_name = $request->input('brand_name');
            $startup->company_name = $request->input('company_name');
            $startup->email = $request->input('email');
            $startup->brief_information = $request->input('brief_description');
            $startup->address = $request->input('registered_address');
            $startup->registration_step = '1';
            $startup->save();

            $round = new StartupRoundModel();
            $round->startup_id = $startup->id;
            $round->name        = 'Round 1';
            $round->round_type = StartupRoundTypeEnum::primary;
            $round->round_status = StartupPrimaryRoundStatusEnum::pending;
            $round->save();

            return self::handleResponse($startup);
        }
    }
    function fundDetailsPost(Request $request)
    {
        if (!Session::has('startup_register_id')) {
            return UtillsHelper::json(0, ['reset' => true]);
        }

        $validation = Validator::make($request->all(), [
            'fund_requirement' => 'required|numeric|min:0',
            'committed_investors' => 'required|json',
            'pre_money_valuation' => 'required|numeric|min:0',
            'current_fund_raise' => 'required|numeric|min:0',
            'funds_required_from_shuru' => 'required|numeric|min:0',
            'min_ticket_size' => 'required|numeric|min:0',
            'pre_money_valuation_basis' => 'required',
            'instrument_and_conversion_condition' => 'required',
            'fund_utilisation_details' => 'required',
            'prev_fund_raised_date' => 'required',
            'prev_fund_raise_investor_name' => 'required',
            'previous_fund_raised_amount' => 'required',
            'valuation_of_previous_round' => 'required',
        ], [], [
            'fund_requirement' => 'Fund Requirement field is required',
            'committed_investors.json' => 'Committed Investors name is required',
            'fund_utilisation_details' => 'Fund Utilisation Details is required',
            'current_fund_raise' => 'Current Fund Raise is required',
            'funds_required_from_shuru' => 'Funds Required From Shuru is required',
            'min_ticket_size' => 'Min Ticket Size is required',
            'pre_money_valuation_basis' => 'Pre Money Valuation Basis is required',
            'instrument_and_conversion_condition' => 'Instrument And Conversion Condition is required',
            'pre_money_valuation' => 'Pre Money Valuation is required',
            'prev_fund_raised_date' => 'Previous Raised Date is required',
            'prev_fund_raise_investor_name' => 'Previous Investor Name is required',
            'previous_fund_raised_amount' => 'Pre Money Valuation is required',
            'valuation_of_previous_round' => 'Valuation of Previous Round is required',
        ]);


        if ($validation->fails()) {
            return UtillsHelper::json(0, ['message' => $validation->errors()->first()]);
        }
        $startup = StartupModel::where('id', Session::get('startup_register_id'))->first();
        if (!$startup) {
            return UtillsHelper::json(0, ['reset' => true]);
        } else {

            $startupfund = new StartupFundRaiseModel();
            $startupfund->startup_id = $startup->id;
            $startupfund->round_id = $startup->lastRounds ? $startup->lastRounds->id : NULL;
            $startupfund->fund_requirement = $request->fund_requirement;
            $input = $request->input('committed_investors'); // Get the input from the request
            $committedInvestors = explode(',', $input); // Split the input string by commas into an array
            $startupfund->committed_investors = $request->committed_investors;
            $startupfund->fund_utilisation_details = $request->fund_utilisation_details;
            $startupfund->current_fund_raise = $request->current_fund_raise;
            $startupfund->funds_required_from_shuru = $request->funds_required_from_shuru;
            $startupfund->min_ticket_size = $request->min_ticket_size;
            $startupfund->pre_money_valuation_basis = $request->pre_money_valuation_basis;
            $startupfund->instrument_and_conversion_condition = $request->instrument_and_conversion_condition;
            $startupfund->pre_money_valuation = $request->pre_money_valuation;
            $startupfund->prev_fund_raised_date = $request->prev_fund_raised_date;
            $startupfund->prev_fund_raise_investor_name = $request->prev_fund_raise_investor_name;
            $startupfund->previous_fund_raised_amount = $request->previous_fund_raised_amount;
            $startupfund->valuation_of_previous_round = $request->valuation_of_previous_round;
            $startupfund->save();

            $startup->registration_step = '2';
            $startup->save();

            return self::handleResponse($startup);
        }
    }

    function keyMetricsPost(Request $request)
    {
        if (!Session::has('startup_register_id')) {
            return UtillsHelper::json(0, ['reset' => true]);
        }

        $validation = Validator::make($request->all(), [
            'founder_capital_contribution' => 'required|numeric|min:0',
            'monthly_revenue_run_rate' => 'required|numeric|min:0',
            'annualized_revenue_run_rate' => 'required|numeric|min:0',
            'current_monthly_burn' => 'required|numeric|min:0',
            'current_cash_balance' => 'required|numeric|min:0',
            'runway_months' => 'required',
            'traction_metrics' => 'required',
            'key_usp_differentiator_entry_barrier' => 'required',
            'competitors' => 'required'
        ], [], [
            'founder_capital_contribution' => 'Founder Capital Contribution field is required',
            'monthly_revenue_run_rate' => 'Monthly Revenue Run Rate is required',
            'annualized_revenue_run_rate' => 'Annualized Revenue Run Rate is required',
            'current_monthly_burn' => 'Current Monthly Burn is required',
            'current_cash_balance' => 'Current Cash Balance is required',
            'runway_months' => 'Runway Months is required',
            'traction_metrics' => 'Traction Metrics is required',
            'key_usp_differentiator_entry_barrier' => 'Key Usp Differentiator Entry Barrier is required',
            'competitors' => 'Competitors is required',
        ]);


        if ($validation->fails()) {
            return UtillsHelper::json(0, ['message' => $validation->errors()->first()]);
        }

        $startup = StartupModel::where('id', Session::get('startup_register_id'))->first();
        if (!$startup) {
            return UtillsHelper::json(0, ['reset' => true]);
        } else {

            $startupfund = new StartupKeyMetricsModel();
            $startupfund->startup_id = $startup->id;
            $startupfund->round_id = $startup->lastRounds ? $startup->lastRounds->id : NULL;
            $startupfund->founder_capital_contribution = $request->founder_capital_contribution;
            $startupfund->monthly_revenue_run_rate = $request->monthly_revenue_run_rate;
            $startupfund->annualized_revenue_run_rate = $request->annualized_revenue_run_rate;
            $startupfund->current_monthly_burn = $request->current_monthly_burn;
            $startupfund->current_cash_balance = $request->current_cash_balance;
            $startupfund->runway_months = $request->runway_months;
            $startupfund->traction_metrics = $request->traction_metrics;
            $startupfund->key_usp_differentiator_entry_barrier = $request->key_usp_differentiator_entry_barrier;
            $startupfund->competitors = $request->competitors;
            $startupfund->save();


            $startup->registration_step = '3';
            $startup->save();

            return self::handleResponse($startup);
        }
    }

    public function financialDetails(Request $request)
    {
        // $id = Session::get('startup_register_id');
        // dd($request);
        // Ensure the user is registered
        if (!Session::has('startup_register_id')) {
            return UtillsHelper::json(0, ['reset' => true]);
        }
    
        // Validation rules
        $validation = Validator::make($request->all(), [
            'previous_raised_year' => 'required|array',
            'post_raised_year' => 'required|array',
            'current_year.*' => 'required|integer|min:1900|max:' . date('Y'),
            'net_revenue' => 'required|array',
            'net_revenue.*' => 'required|numeric|min:0',
            'ebitda' => 'required|array',
            'ebitda.*' => 'required|numeric|min:0',
            'pat' => 'required|numeric|min:0',
            // 'raised_date' => 'required|array',
            // 'raised_date.*' => 'required|date',
            // 'investor_name' => 'required|array',
            // 'investor_name.*' => 'required|string|max:255',
            // 'previous_fund_raised_amount' => 'required|array',
            // 'previous_fund_raised_amount.*' => 'required|numeric|min:0',
            // 'valuation_of_previous_round' => 'required|array',
            // 'valuation_of_previous_round.*' => 'required|numeric|min:0',
        ], [], [
            'previous_raised_year' => 'previous_raised_year Year',
            'post_raised_year' => 'previous_raised_year Year',
            'net_revenue' => 'Net Revenue',
            'net_revenue.*' => 'Net Revenue',
            'ebitda' => 'EBITDA',
            'ebitda.*' => 'EBITDA',
            'pat' => 'PAT',
            // 'raised_date' => 'Raised Date',
            // 'raised_date.*' => 'Raised Date',
            // 'investor_name' => 'Investor Name',
            // 'investor_name.*' => 'Investor Name',
            // 'previous_fund_raised_amount' => 'Previous Fund Raised Amount',
            // 'previous_fund_raised_amount.*' => 'Previous Fund Raised Amount',
            // 'valuation_of_previous_round' => 'Valuation of Previous Round',
            // 'valuation_of_previous_round.*' => 'Valuation of Previous Round',
        ]);
    
        if ($validation->fails()) {
            return UtillsHelper::json(0, ['message' => $validation->errors()->first()]);
        }
    
        // Retrieve the startup model
        $startup = StartupModel::where('id', Session::get('startup_register_id'))->first();
        if (!$startup) {
            return UtillsHelper::json(0, ['reset' => true]);
        }
    
        // Save current financial details
        foreach ($request->previous_raised_year as $index => $year) {
            $financialDetail = new StartupFinancialDetailModel();
            $financialDetail->startup_id = $startup->id;
            $financialDetail->round_id = $startup->lastRounds ? $startup->lastRounds->id : NULL;
            $financialDetail->year = $year;
            $financialDetail->net_revenue = $request->net_revenue[$index];
            $financialDetail->ebitda = $request->ebitda[$index];
            $financialDetail->pat = $request->pat;
            $financialDetail->save();
        }
    
        // Save post fund raise details
        foreach ($request->post_raised_year as $index => $postYear) {
            $postFundRaise = new StartupFinancialDetailModel(); // Adjust model name as needed
            $postFundRaise->startup_id = $startup->id;
            $postFundRaise->round_id = $startup->lastRounds ? $startup->lastRounds->id : NULL;
            $postFundRaise->year = $postYear;
            $postFundRaise->revenue_expected = $request->revenue_expected[$index];
            $postFundRaise->current_fy_closing_ebitda = $request->current_fy_closing_ebitda[$index];
            $postFundRaise->current_fy_closing_pat = $request->current_fy_closing_pat[$index];
            $postFundRaise->next_fy_revenue = $request->next_fy_revenue[$index];
            $postFundRaise->next_fy_expense = $request->next_fy_expense[$index];
            $postFundRaise->next_fy_ebitda = $request->next_fy_ebitda[$index];
            $postFundRaise->next_fy_pat = $request->next_fy_pat[$index];
            $postFundRaise->save();
        }
    
        // Update the registration step
        $startup->registration_step = '4';
        $startup->save();
    
        return self::handleResponse($startup);
    }
    public function otherDetails(Request $request)
    {
        // Ensure the user is registered
        if (!Session::has('startup_register_id')) {
            return UtillsHelper::json(0, ['reset' => true]);
        }
    
        // Validation rules
        $validation = Validator::make($request->all(), [
            'number_of_founders' => 'required|integer',
            'name_of_founder' => 'required|string|max:255',
            'age' => 'required|integer',
            'education_qualification' => 'required|string|max:255',
            'work_exps' => 'required|string|max:255',
            'startup_failures_successful_exits' => 'required|string',
            'pitchdeck' => 'required|url',
            'financial_model' => 'required|url',
            'founder_email_id' => 'required|email',
            'founder_contact_number' => 'required|string|max:255',
        ], [], [
            'number_of_founders' => 'Number of Founders',
            'name_of_founder' => 'Name of Founder',
            'age' => 'Age',
            'education_qualification' => 'Education Qualification',
            'work_exps' => 'Work Experience',
            'startup_failures_successful_exits' => 'Startup Failures/Successful Exits',
            'pitchdeck' => 'Pitch Deck URL',
            'financial_model' => 'Financial Model URL',
            'founder_email_id' => 'Founder Email ID',
            'founder_contact_number' => 'Founder Contact Number',
        ]);
    
        if ($validation->fails()) {
            return UtillsHelper::json(0, ['message' => $validation->errors()->first()]);
        }
    
        // Retrieve the startup model
        $startup = StartupModel::where('id', Session::get('startup_register_id'))->first();
        if (!$startup) {
            return UtillsHelper::json(0, ['reset' => true]);
        }
    
        // Save other details
        $otherDetails = new StartupOtherDetailModel();
        $otherDetails->startup_id = $startup->id;
        $otherDetails->round_id = $startup->lastRounds ? $startup->lastRounds->id : null;
        $otherDetails->number_of_founders = $request->number_of_founders;
        $otherDetails->name_of_founder = $request->name_of_founder;
        $otherDetails->age = $request->age;
        $otherDetails->education_qualification = $request->education_qualification;
        $otherDetails->work_exp = $request->work_exps;
        $otherDetails->startup_failures_successful_exits = $request->startup_failures_successful_exits;
        $otherDetails->pitchdeck = $request->pitchdeck;
        $otherDetails->financial_model = $request->financial_model;
        $otherDetails->founder_email_id = $request->founder_email_id;
        $otherDetails->founder_contact_number = $request->founder_contact_number;
        $otherDetails->save();
    
        // Update the registration step
        $startup->registration_step = '5';
        $startup->save();
    
        return self::handleResponse($startup);
    }
    
    public function storeDocuments(Request $request)
    {
        // dd($request);
        // Ensure the user is registered
        if (!Session::has('startup_register_id')) {
            return UtillsHelper::json(0, ['reset' => true]);
        }
    
        // Validation rules for files
        $validation = Validator::make($request->all(), [
            'pitch_deck' => 'required|mimes:pdf|max:',//.CommonHelper::appSettings('file_document_max_size'),
            'fina_projection' => 'nullable|mimes:pdf|max:',//.CommonHelper::appSettings('file_document_max_size'),
            'dd_report' => 'nullable|mimes:pdf|max:',//.CommonHelper::appSettings('file_document_max_size'),
            'vreport' => 'nullable|mimes:pdf|max:',//.CommonHelper::appSettings('file_document_max_size'),
            'dpiit_file' => 'nullable|mimes:pdf|max:',//.CommonHelper::appSettings('file_document_max_size'),
            'long_banner' => 'nullable|mimes:jpg,jpeg,png|max:',//.CommonHelper::appSettings('file_image_max_size'),
            'banner' => 'nullable|mimes:jpg,jpeg,png|max:',//.CommonHelper::appSettings('file_image_max_size'),
            'logo' => 'nullable|mimes:jpg,jpeg,png|max:',//.CommonHelper::appSettings('file_image_max_size'),
            // 'product_video' => 'nullable|mimes:mkv,mp4,avi|max:',//.CommonHelper::appSettings('file_video_max_size'),
            // 'pitch_video' => 'nullable|mimes:mkv,mp4,avi|max:',//.CommonHelper::appSettings('file_video_max_size'),
        ], [], [
            'pitch_deck' => 'Pitch Deck (PDF)',
            'fina_projection' => 'Financial Projections (PDF)',
            'dd_report' => 'DD Report (PDF)',
            'vreport' => 'Valuation Report (PDF)',
            'dpiit_file' => 'DPIIT Certificate (PDF)',
            'long_banner' => 'Long Banner',
            'banner' => 'Banner',
            'logo' => 'Logo',
            // 'product_video' => 'Product Video',
            // 'pitch_video' => 'Pitch Video',
        ]);
    
        // if ($validation->fails()) {
        //     return UtillsHelper::json(0, ['message' => $validation->errors()->first()]);
        // }
    
        // Retrieve the startup model
        $startup = StartupModel::where('id', Session::get('startup_register_id'))->first();
        if (!$startup) {
            return UtillsHelper::json(0, ['reset' => true]);
        }
    
        // Find or create the StartupDocumentModel instance
        $startupMIS = StartupDetailsModel::where('startup_id', $startup->id)->first();
        if (!$startupMIS) {
            $startupMIS = new StartupDetailsModel();
            $startupMIS->startup_id = $startup->id;
        }
    
        // Handle file uploads using FileUpDownHelper
        if ($request->hasFile('pitch_deck_file')) {
            $startupMIS->pitch_deck_file = FileUpDownHelper::startup_pitch_deck_upload($request->file('pitch_deck_file'));
        }
        if ($request->hasFile('fina_projection')) {
            $startupMIS->financial_projection = FileUpDownHelper::startup_financial_projection_upload($request->file('fina_projection'));
        }
        if ($request->hasFile('dd_report')) {
            $startupMIS->dd_report = FileUpDownHelper::startup_dd_report_upload($request->file('dd_report'));
        }
        if ($request->hasFile('vreport')) {
            $startupMIS->valuation_report = FileUpDownHelper::startup_valuation_report_upload($request->file('vreport'));
        }
        if ($request->hasFile('dpiit_file')) {
            $startupMIS->dpiit_certificate = FileUpDownHelper::startup_dpiit_certificate_upload($request->file('dpiit_file'));
        }
        if ($request->hasFile('long_banner')) {
            $startupMIS->long_banner = FileUpDownHelper::startup_long_banner_upload($request->file('long_banner'));
        }
        if ($request->hasFile('banner')) {
            $startupMIS->banner = FileUpDownHelper::startup_short_banner_upload($request->file('banner'));
        }
        if ($request->hasFile('logo')) {
            $startupMIS->logo = FileUpDownHelper::startup_logo_upload($request->file('logo'));
        }
        if ($request->hasFile('product_video')) {
            $startupMIS->product_video = FileUpDownHelper::startup_product_video_upload($request->file('product_video'));
        }
        if ($request->hasFile('pitch_video')) {
            $startupMIS->pitch_video = FileUpDownHelper::startup_pitch_video_upload($request->file('pitch_video'));
        }
    
        // Save the document details
        $startupMIS->save();
    
        // Update the registration step
        $startup->registration_step = '6'; // Assuming this is the final step
        $startup->save();
    
        return self::handleResponse($startup);
    }
    
    
    function resendOtp(Request $request): JsonResponse
    {
        if (!Session::has('startup_register_id')) {
            return UtillsHelper::json(0, ['reset' => true]);
        }

        $startup = StartupModel::where('id', Session::get('startup_register_id'))->first();
        if (!$startup) {
            return UtillsHelper::json(0, ['reset' => true]);
        } else {
            UtillsHelper::sendVerificationCode($startup->id, StartupModel::class, $startup->mobile_number, CodeVerificationTypeEnum::register);
            return UtillsHelper::json(1, ['message' => 'Verification code sent to ' . $startup->mobile_number]);
        }
    }

    function verifyOtp(Request $request): JsonResponse
    {
        if (!Session::has('startup_register_id')) {
            return UtillsHelper::json(0, ['reset' => true]);
        }

        $startup = StartupModel::where('id', Session::get('startup_register_id'))->first();
        if (!$startup) {
            return UtillsHelper::json(0, ['reset' => true]);
        } else {
            $validation = Validator::make($request->all(), [
                'otp' => 'required'
            ], [], [
                'otp'                                  => 'Verification code is required'
            ]);
            if ($validation->fails()) {
                return UtillsHelper::json(0, ['message' => $validation->errors()->first()]);
            }

            $code = UtillsHelper::getVerificationCode($request->otp, $startup->id, StartupModel::class, CodeVerificationTypeEnum::register);
            if (!$code) {
                return UtillsHelper::json(0, ['message' => 'Verification code is not valid']);
            } else {
                $code->is_used = '1';
                $code->save();
                return self::handleResponse($startup);
            }
        }
    }

    function handleResponse($startup): JsonResponse
    {
        // dd($startup);
        if ($startup->password == NULL) {
            return UtillsHelper::json(1, ['view' => view('front.common.auth.change-password', [
                'title'     => 'Set your password',
                'action'    => route('front.raise.auth.post.register.setPassword'),
                'redirect'  => ''
            ])->render()]);
        } else {
            if ($startup->registration_step == '0') {
                return UtillsHelper::json(1, ['main' => view('front.startup.auth.register.childs.main_startup_details')->render()]);
            } else if ($startup->registration_step == '1') {
                return UtillsHelper::json(1, ['main' => view('front.startup.auth.register.childs.fund_raise')->render()]);
            } else if ($startup->registration_step == '2') {
                return UtillsHelper::json(1, ['main' => view('front.startup.auth.register.childs.key_metrics')->render()]);
            } else if ($startup->registration_step == '3') {
                return UtillsHelper::json(1, ['main' => view('front.startup.auth.register.childs.financial_details')->render()]);
            }else if ($startup->registration_step == '4') {
                return UtillsHelper::json(1, ['main' => view('front.startup.auth.register.childs.other_details')->render()]);
            }else if ($startup->registration_step == '5') {
                return UtillsHelper::json(1, ['main' => view('front.startup.auth.register.childs.document')->render()]);
            } else {
                return UtillsHelper::json(1, ['main' => view('front.startup.auth.register.childs.success')->render()]);
            }
        }
    }
}
