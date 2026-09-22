<?php

namespace App\Http\Controllers\Web\Front\Auth\Partner;

use App\Enums\Utills\CodeVerificationTypeEnum;
use App\Helpers\UtillsHelper;
use App\Http\Controllers\Controller;
use App\Models\InvestorModel;
use App\Models\PartnerModel;
use App\Models\ReportsVerificationCodeModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

class PasswordResetController extends Controller
{
    function index(): View
    {
        setPageTitle('Forgot Password');
        addJavascriptFile('front-assets/js/custom/auth/partner/forgot.js');
        return view('front.partner.auth.forgot');
    }

    public function forgot(Request $request): JsonResponse
    {
        $validation = Validator::make($request->all(), [
            'mobile_no' => 'required|numeric|digits:10'
        ], [], [
            'mobile_no'                                  => 'Mobile number is required'
        ]);
        if ($validation->fails()) {
            return UtillsHelper::json(0, ['message' => $validation->errors()->first()]);
        }

        $partner = PartnerModel::where('is_deleted', '0')->where('mobile_number', $request->mobile_no)->first();
        if (!$partner) {
            return UtillsHelper::json(0, ['message' => 'Mobile number not registered.']);
        } else {
            UtillsHelper::sendVerificationCode($partner->id, PartnerModel::class, $request->mobile_no, CodeVerificationTypeEnum::forgot_password);
            Session::put('partner_forget_id', $partner->id);
            return UtillsHelper::json(1, ['view' => view('front.common.auth.verifyotp', [
                'mobile_no' => $request->mobile_no,
                'form_route' => route('front.business.auth.post.forgot.verifyotp'),
                'resend_route' => route('front.business.auth.post.forgot.resendotp')
            ])->render()]);
        }
    }

    public function resendOtp(Request $request): JsonResponse
    {
        if (!Session::has('partner_forget_id')) {
            return UtillsHelper::json(0, ['reset' => true]);
        }

        $partner = PartnerModel::where('id', Session::get('partner_forget_id'))->first();
        if (!$partner) {
            return UtillsHelper::json(0, ['reset' => true]);
        } else {
            UtillsHelper::sendVerificationCode($partner->id, PartnerModel::class, $partner->mobile_number, CodeVerificationTypeEnum::forgot_password);
            return UtillsHelper::json(1, ['message' => 'Verification code sent to ' . $partner->mobile_number]);
        }
    }

    public function verifyOtp(Request $request): JsonResponse
    {
        if (!Session::has('partner_forget_id')) {
            return UtillsHelper::json(0, ['reset' => true]);
        }

        $partner = PartnerModel::where('id', Session::get('partner_forget_id'))->first();
        if (!$partner) {
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
            $code = UtillsHelper::getVerificationCode($request->otp, $partner->id, PartnerModel::class, CodeVerificationTypeEnum::forgot_password);
            if (!$code) {
                return UtillsHelper::json(0, ['message' => 'Verification code is not valid']);
            } else {
                $code->is_used = '1';
                $code->save();
                return UtillsHelper::json(1, ['view' => view('front.common.auth.change-password', [
                    'title' => 'Change your password',
                    'action'    => route('front.business.auth.post.forgot.changepassword'),
                    'redirect'  => route('front.business.auth.login')
                ])->render()]);
            }
        }
    }

    public function changePassword(Request $request): JsonResponse
    {
        if (!Session::has('partner_forget_id')) {
            return UtillsHelper::json(0, ['reset' => true]);
        }

        $partner = PartnerModel::where('id', Session::get('partner_forget_id'))->first();
        if (!$partner) {
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

            $partner->password = Hash::make($request->password);
            $partner->save();

            Session::forget('partner_forget_id');
            Session::flash('success', 'Password changed');
            return UtillsHelper::json(1, ['message' => 'Password reset success.']);
        }
    }
}
