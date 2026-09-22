<?php

namespace App\Http\Controllers\Web\Front\Auth\Startup;

use App\Enums\Utills\CodeVerificationTypeEnum;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Helpers\UtillsHelper;
use App\Models\StartupModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

class PasswordResetController extends Controller
{
    function index(): View
    {
        setPageTitle('Startup Forgot Password');
        addJavascriptFile('front-assets/js/custom/auth/startup/forgot.js');
        return view('front.startup.auth.forgot');
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

        $startup = StartupModel::where('is_deleted', '0')->where('registration_step', '6')->where('mobile_number', $request->mobile_no)->first();
        if (!$startup) {
            return UtillsHelper::json(0, ['message' => 'Mobile number not registered.']);
        } else {
            UtillsHelper::sendVerificationCode($startup->id, StartupModel::class, $request->mobile_no, CodeVerificationTypeEnum::forgot_password);
            Session::put('startup_forget_id', $startup->id);
            return UtillsHelper::json(1, ['view' => view('front.common.auth.verifyotp', [
                'mobile_no' => $request->mobile_no,
                'form_route' => route('front.raise.auth.post.forgot.verifyotp'),
                'resend_route' => route('front.raise.auth.post.forgot.resendotp')
            ])->render()]);
        }
    }

    public function resendOtp(Request $request): JsonResponse
    {
        if (!Session::has('startup_forget_id')) {
            return UtillsHelper::json(0, ['reset' => true]);
        }

        $startup = StartupModel::where('id', Session::get('startup_forget_id'))->first();
        if (!$startup) {
            return UtillsHelper::json(0, ['reset' => true]);
        } else {
            UtillsHelper::sendVerificationCode($startup->id, StartupModel::class, $startup->mobile_number, CodeVerificationTypeEnum::forgot_password);
            return UtillsHelper::json(1, ['message' => 'Verification code sent to ' . $startup->mobile_number]);
        }
    }

    public function verifyOtp(Request $request): JsonResponse
    {


        if (!Session::has('startup_forget_id')) {
            return UtillsHelper::json(0, ['reset' => true]);
        }

        $startup = StartupModel::where('id', Session::get('startup_forget_id'))->first();
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
            $code = UtillsHelper::getVerificationCode($request->otp, $startup->id, StartupModel::class, CodeVerificationTypeEnum::forgot_password);
            if (!$code) {
                return UtillsHelper::json(0, ['message' => 'Verification code is not valid']);
            } else {
                $code->is_used = '1';
                $code->save();
                return UtillsHelper::json(1, ['view' => view('front.common.auth.change-password', [
                    'title' => 'Change your password',
                    'action'    => route('front.raise.auth.post.forgot.changepassword'),
                    'redirect'  => route('front.raise.auth.login')
                ])->render()]);
            }
        }
    }

    public function changePassword(Request $request): JsonResponse
    {
        if (!Session::has('startup_forget_id')) {
            return UtillsHelper::json(0, ['reset' => true]);
        }

        $startup = StartupModel::where('id', Session::get('startup_forget_id'))->first();
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

            Session::forget('startup_forget_id');
            Session::flash('success', 'Password changed');
            return UtillsHelper::json(1, ['message' => 'Password reset success.']);
        }
    }
}
