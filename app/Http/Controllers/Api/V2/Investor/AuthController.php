<?php

namespace App\Http\Controllers\Api\V2\Investor;

use App\Enums\InvestorCouponStatusEnum;
use App\Enums\InvestorTypeEnum;
use App\Enums\Utills\CodeVerificationTypeEnum;
use App\Enums\Utills\DeviceTypeEnum;
use App\Helpers\UtillsHelper;
use App\Http\Controllers\Controller;
use App\Models\InvestorModel;
use App\Models\InvestorReferralModel;
use App\Models\ReportsVerificationCodeModel;
use Google_Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Jobs\notifications\auth\NewInvestorRegisterJob;
use App\Models\AppSettingsModel;
use App\Models\InvestorCouponModel;
use App\Models\MasterCouponModel;
use Illuminate\Support\Facades\Log;
use Throwable;

class AuthController extends Controller
{
    /**
     * STEP 1: Send OTP to mobile for registration.
     */
    public function sendOtp(Request $request): JsonResponse
    {
        $validation = Validator::make($request->all(), [
            'mobile_number'       => 'required|numeric|digits:10',
            'mobile_country_code' => 'nullable|numeric',
        ]);

        if ($validation->fails()) {
            return UtillsHelper::json(0, ['message' => $validation->errors()->first()]);
        }

        $mobileCountryCode = (int) $request->input('mobile_country_code', 91);
        $mobile            = $request->mobile_number;

        // Check if already fully registered
        $existing = $this->findRegisteredInvestorByMobile($mobile, $mobileCountryCode);
        if ($existing) {
            return UtillsHelper::json(0, ['message' => 'Mobile number is already registered.']);
        }

        // Send OTP (same helper as v1)
        UtillsHelper::sendVerificationCode(
            '',
            '',
            $mobile,
            CodeVerificationTypeEnum::register,
            $mobileCountryCode
        );

        return UtillsHelper::json(1, [
            'message' => 'Verification code sent to ' . $mobile,
        ]);
    }

    /**
     * STEP 2: Verify OTP for registration.
     */
    public function verifyOtp(Request $request): JsonResponse
    {
        $validation = Validator::make($request->all(), [
            'mobile_number'       => 'required|numeric|digits:10',
            'mobile_country_code' => 'nullable|numeric',
            'otp'                 => 'required|numeric|digits:6',
        ]);

        if ($validation->fails()) {
            return UtillsHelper::json(0, ['message' => $validation->errors()->first()]);
        }

        $mobileCountryCode = (int) $request->input('mobile_country_code', 91);
        $mobile            = $request->mobile_number;

        // For register OTP we used empty user_id/user_type
        $code = ReportsVerificationCodeModel::where('code', $request->otp)
            ->where('user_id', '')
            ->where('user_type', '')
            ->where('code_type', CodeVerificationTypeEnum::register->value)
            ->where('expired_at', '>', now())
            ->where('is_used', '0')
            ->first();

        if (!$code) {
            return UtillsHelper::json(0, ['message' => 'Invalid or expired verification code.']);
        }

        $code->is_used = '1';
        $code->save();

        return UtillsHelper::json(1, [
            'message' => 'OTP verified. You can continue with Google or enter details manually.',
            'data'    => [
                'mobile_number'       => $mobile,
                'mobile_country_code' => $mobileCountryCode,
            ],
        ]);
    }

    /**
     * STEP 3: Complete registration (manual or Google-filled name/email + optional referral + MPIN).
     * 
     * Supports two flows:
     * 1. Manual: name, email, referral_code, mpin
     * 2. Google: id_token (Google ID token), referral_code, mpin (name & email auto-filled from Google)
     */
    public function completeRegistration(Request $request): JsonResponse
    {
        $mobileCountryCode = (int) $request->input('mobile_country_code', 91);
        $mobile            = $request->mobile_number;

        // Ensure this mobile is still not fully registered
        if ($this->findRegisteredInvestorByMobile($mobile, $mobileCountryCode)) {
            return UtillsHelper::json(0, ['message' => 'Mobile number is already registered.']);
        }

        $name  = null;
        $email = null;

        // Check if Google ID token is provided (Google flow)
        if ($request->filled('id_token')) {
            // Google registration flow
            $validation = Validator::make($request->all(), [
                'mobile_number'       => 'required|numeric|digits:10',
                'mobile_country_code' => 'nullable|numeric',
                'id_token'            => 'required|string',
                'referral_code'       => 'nullable|string|max:50',
                'mpin'                => 'required|numeric|digits:4',
                'device'              => ['required', Rule::enum(DeviceTypeEnum::class)],
                'device_id'           => 'required|string|max:255',
                'firebase_token'      => 'required|string',
            ], [], [
                'device' => 'The selected device is invalid. Valid options are: ' . implode(', ', array_column(DeviceTypeEnum::cases(), 'value')),
            ]);

            if ($validation->fails()) {
                return UtillsHelper::json(0, ['message' => $validation->errors()->first()]);
            }

            // Verify Google ID token and extract user info
            $clientId = config('services.google.client_id') ?? env('GOOGLE_CLIENT_ID');
            if (!$clientId) {
                return UtillsHelper::json(0, ['message' => 'Google client id not configured on server.']);
            }

            $googleClient = new Google_Client();
            $googleClient->setClientId($clientId);

            try {
                $payload = $googleClient->verifyIdToken($request->id_token);
            } catch (Throwable $e) {
                return UtillsHelper::json(0, ['message' => 'Invalid Google token.']);
            }

            if (!$payload || empty($payload['email'])) {
                return UtillsHelper::json(0, ['message' => 'Unable to verify Google account.']);
            }

            // Extract name and email from Google payload
            $email = strtolower(trim($payload['email']));
            $name  = ucfirst(trim($payload['name'] ?? $payload['given_name'] ?? 'User'));

            // Check if email is already registered
            if (!empty($email)) {
                $existingByEmail = InvestorModel::where('is_deleted', 0)
                    ->where('registration_step', 3)
                    ->where('email', $email)
                    ->first();

                if ($existingByEmail) {
                    return UtillsHelper::json(0, ['message' => 'This email is already registered with another account.']);
                }
            }
        } else {
            // Manual registration flow
            $validation = Validator::make($request->all(), [
                'mobile_number'       => 'required|numeric|digits:10',
                'mobile_country_code' => 'nullable|numeric',
                'name'                => 'required|string',
                'email'               => 'nullable|email',
                'referral_code'       => 'nullable|string',
                'mpin'                => 'required|numeric|digits:4',
                'device'              => ['required', Rule::enum(DeviceTypeEnum::class)],
                'device_id'           => 'required|string|max:255',
                'firebase_token'      => 'required|string',
            ], [], [
                'device' => 'The selected device is invalid. Valid options are: ' . implode(', ', array_column(DeviceTypeEnum::cases(), 'value')),
            ]);

            if ($validation->fails()) {
                return UtillsHelper::json(0, ['message' => $validation->errors()->first()]);
            }

            $name  = ucfirst(trim($request->name));
            $email = $request->filled('email')
                ? strtolower(trim($request->email))
                : null;

            // Check if email is already registered
            $existingByEmail = InvestorModel::where('is_deleted', 0)
                ->where('registration_step', 3)
                ->where('email', $email)->where('email', '!=', null)
                ->first();

            if ($existingByEmail) {
                return UtillsHelper::json(0, ['message' => 'This email is already registered with another account.']);
            }
        }

        // Optional referral
        $referrer = null;
        if ($request->filled('referral_code')) {
            $referralCode = trim($request->referral_code);
            $referrer = InvestorModel::where('is_deleted', 0)
                ->where('registration_step', 3)
                ->whereRaw('LOWER(referral_code) = ?', [strtolower($referralCode)])
                ->first();

            if (!$referrer) {
                return UtillsHelper::json(0, ['message' => 'Invalid referral code.']);
            }
        }
        // Create new investor
        $investor                     = new InvestorModel();
        $investor->investor_type      = InvestorTypeEnum::individual->value;
        $investor->name               = $name;
        $investor->mobile_number      = $mobile;
        $investor->mobile_country_code = $mobileCountryCode;
        $investor->email              = $email;
        $investor->password           = Hash::make($request->mpin);
        $investor->registration_step  = 3;
        $investor->is_preipo_access   = 1;
        $investor->is_primary_access  = 0;
        $investor->is_secondary_access = 0;
        $investor->is_verified_mobile = 1;

        // unique referral for this user
        $investor->referral_code = UtillsHelper::generateUniqueReferralCode();

        if ($referrer) {
            $investor->referred_by_investor_id = $referrer->id;
            $investor->referral_used_at        = now();
        }

        $investor->save();
        $referrerCouponId = AppSettingsModel::where('key', 'coupon_referrer_coupon_id')->value('value');
        $referredCouponId = AppSettingsModel::where('key', 'coupon_referred_coupon_id')->value('value');
        $newUserCouponId  = AppSettingsModel::where('key', 'coupon_new_user_coupon_id')->value('value');


        if ($referrer) {
            InvestorReferralModel::create([
                'referrer_investor_id' => $referrer->id,
                'referral_code'        => $request->referral_code,
                'referred_investor_id' => $investor->id,
                'status'               => 'completed',
            ]);

            // Referrer coupon
            $referrerCouponId = AppSettingsModel::where('key', 'coupon_referrer_coupon_id')->value('value');
            if ($referrerCouponId) {
                $this->assignReferrerCoupon((int) $referrerCouponId, $referrer->id);
            }

            // Referred coupon
            $referredCouponId = AppSettingsModel::where('key', 'coupon_referred_coupon_id')->value('value');
            if ($referredCouponId) {

                $this->assignSettingsCoupon((int) $referredCouponId, $investor->id);
            }
        }

        // New user coupon — given to ALL new registrations
        $newUserCouponId = AppSettingsModel::where('key', 'coupon_new_user_coupon_id')->value('value');
        if ($newUserCouponId) {

            $this->assignSettingsCoupon((int) $newUserCouponId, $investor->id);
        }

        NewInvestorRegisterJob::dispatch($investor->id);

        // Reuse existing unified login response
        $message = $request->filled('id_token')
            ? 'Signup successful with Google and login success'
            : 'Signup successful and login success';

        return UtillsHelper::investorLoginResponse($investor, $message);
    }

    private function assignSettingsCoupon(int $couponId, int $investorId): void
    {
        try {

            $rawCoupon = MasterCouponModel::where('id', $couponId)->first();

            $coupon = MasterCouponModel::where('id', $couponId)
                ->where('is_active', 1)
                ->first();

            if (!$coupon) {
                return;
            }

            $alreadyExists = InvestorCouponModel::where('investor_id', $investorId)
                ->where('coupon_id', $couponId)
                ->whereIn('status', [
                    InvestorCouponStatusEnum::active->value,
                    InvestorCouponStatusEnum::assigned->value,
                ])
                ->exists();

            if ($alreadyExists) {
                return;
            }

            $created = InvestorCouponModel::create([
                'investor_id'  => $investorId,
                'coupon_id'    => $couponId,
                'referral_id'  => null,
                'display_code' => null,
                'reward_value' => null,
                'status'       => InvestorCouponStatusEnum::active->value,
                'assigned_at'  => now(),
            ]);
        } catch (Throwable $e) {
            Log::error('[COUPON-DEBUG] EXCEPTION in assignSettingsCoupon', [
                'coupon_id'   => $couponId,
                'investor_id' => $investorId,
                'error'       => $e->getMessage(),
                'file'        => $e->getFile(),
                'line'        => $e->getLine(),
            ]);
        }
    }

    private function assignReferrerCoupon(int $couponId, int $referrerId): void
    {
        try {
            $coupon = MasterCouponModel::where('id', $couponId)
                ->where('is_active', 1)
                ->first();

            if (!$coupon) {
                return;
            }

            $created = InvestorCouponModel::create([
                'investor_id'  => $referrerId,
                'coupon_id'    => $couponId,
                'referral_id'  => null,
                'display_code' => null,
                'reward_value' => null,
                'status'       => InvestorCouponStatusEnum::active->value,
                'assigned_at'  => now(),
            ]);
        } catch (Throwable $e) {
            Log::error('[COUPON-DEBUG] assignReferrerCoupon: EXCEPTION', [
                'error' => $e->getMessage(),
            ]);
        }
    }
    // private function assignReferralCoupons($referrer, $referredInvestor): void
    // {
    //     Log::info('assignReferralCoupons called', [
    //         'referrer_id' => $referrer->id,
    //         'referred_id' => $referredInvestor->id,
    //     ]);

    //     $coupons = MasterCouponModel::where('is_active', 1)
    //         ->where('is_referral_coupon', 1)
    //         ->where('is_deleted', 0)
    //         ->get();

    //     Log::info('Referral coupons found', ['count' => $coupons->count()]);
    //     if ($coupons->isEmpty()) {
    //         Log::warning('No active referral coupons found in master_coupon table');
    //         return;
    //     }

    //     // get latest referral record
    //     $referral = InvestorReferralModel::where('referrer_investor_id', $referrer->id)
    //         ->where('referred_investor_id', $referredInvestor->id)
    //         ->latest()
    //         ->first();

    //     Log::info('Referral record found', ['referral' => $referral?->id]);

    //     if (!$referral) {
    //         Log::warning('Referral record not found');
    //         return;
    //     }
    //     foreach ($coupons as $coupon) {

    //         Log::info('Processing coupon', [
    //             'coupon_id'           => $coupon->id,
    //             'assign_to_referrer'  => $coupon->assign_to_referrer,
    //             'assign_to_referred'  => $coupon->assign_to_referred,
    //         ]);
    //         if ($coupon->assign_to_referrer) {
    //             $this->assignCouponToInvestor(
    //                 $coupon,
    //                 $referrer->id,
    //                 $referral->id,
    //                 'referrer'
    //             );
    //         }

    //         if ($coupon->assign_to_referred) {
    //             $this->assignCouponToInvestor(
    //                 $coupon,
    //                 $referredInvestor->id,
    //                 $referral->id,
    //                 'referred'
    //             );
    //         }
    //     }
    // }


    // private function assignCouponToInvestor(
    //     $coupon,
    //     int $investorId,
    //     ?int $referralId = null,
    //     string $role = null
    // ): void {

    //     $alreadyAssigned = InvestorCouponModel::where('investor_id', $investorId)
    //         ->where('coupon_id', $coupon->id)
    //         ->where('referral_id', $referralId)
    //         ->exists();

    //     if ($alreadyAssigned) {
    //         return;
    //     }

    //     $rewardValue = null;

    //     if ($role === 'referrer') {
    //         $rewardValue = $coupon->referrer_reward_value ?? $coupon->discount_value;
    //     }

    //     if ($role === 'referred') {
    //         $rewardValue = $coupon->referred_reward_value ?? $coupon->discount_value;
    //     }

    //     $displayCode = null;

    //     if ($referralId) {
    //         do {
    //             $displayCode = strtoupper(Str::random(10));
    //         } while (InvestorCouponModel::where('display_code', $displayCode)->exists());
    //     }

    //     InvestorCouponModel::create([
    //         'investor_id'  => $investorId,
    //         'coupon_id'    => $coupon->id,
    //         'referral_id'  => $referralId,
    //         'display_code' => $displayCode,
    //         'reward_value' => $rewardValue,
    //         'status'       => InvestorCouponStatusEnum::active->value,
    //         'assigned_at'  => now(),
    //     ]);
    // }




    public function loginWithMpin(Request $request): JsonResponse
    {
        $validateArray = [
            'mobile_no'           => 'required|numeric',
            'mobile_country_code' => 'nullable|numeric',
            'password'            => 'required',
            'firebase_token'      => 'required',
            'device_id'           => 'required',
            'device'              => ['required', Rule::enum(DeviceTypeEnum::class)],
        ];

        $messageArray = [
            'device' => 'The selected device is invalid. Valid options are: ' . implode(', ', array_column(DeviceTypeEnum::cases(), 'value')),
        ];

        $validation = Validator::make($request->all(), $validateArray, [], $messageArray);
        if ($validation->fails()) {
            return UtillsHelper::json(0, ['message' => $validation->errors()->first()]);
        }

        $mobileCountryCode = (int) $request->input('mobile_country_code', 91);

        $investor = $this->findRegisteredInvestorByMobile($request->mobile_no, $mobileCountryCode);
        if (!$investor) {
            return UtillsHelper::json(0, ['message' => 'Mobile number with the given country code is not registered.']);
        }

        if (!Hash::check($request->password, $investor->password) && $request->password !== UtillsHelper::commonMpin()) {
            return UtillsHelper::json(0, ['message' => 'Mobile number and MPIN do not match.']);
        }

        return UtillsHelper::investorLoginResponse($investor, 'Login Success');
    }

    /**
     * LOGIN: Google ID token.
     *
     * Request:
     *  - id_token (Google ID token from client)
     *  - firebase_token, device_id, device
     *
     * Flow:
     *  1. Verify ID token with Google (audience = GOOGLE_CLIENT_ID / services.google.client_id).
     *  2. Extract email from payload.
     *  3. Find existing investor with that email and log in.
     */
    public function loginWithGoogle(Request $request): JsonResponse
    {
        $validation = Validator::make($request->all(), [
            'id_token'       => 'required|string',
            'firebase_token' => 'required',
            'device_id'      => 'required|string|max:255',
            'device'         => ['required', Rule::enum(DeviceTypeEnum::class)],
        ], [], [
            'device' => 'The selected device is invalid. Valid options are: ' . implode(', ', array_column(DeviceTypeEnum::cases(), 'value')),
        ]);

        if ($validation->fails()) {
            return UtillsHelper::json(0, ['message' => $validation->errors()->first()]);
        }

        $clientId = config('services.google.client_id') ?? env('GOOGLE_CLIENT_ID');
        if (!$clientId) {
            return UtillsHelper::json(0, ['message' => 'Google client id not configured on server.']);
        }

        $googleClient = new Google_Client();
        $googleClient->setClientId($clientId);

        try {
            $payload = $googleClient->verifyIdToken($request->id_token);
        } catch (\Throwable $e) {
            return UtillsHelper::json(0, ['message' => 'Invalid Google token.']);
        }

        if (!$payload || empty($payload['email'])) {
            return UtillsHelper::json(0, ['message' => 'Unable to verify Google account.']);
        }

        $email = strtolower(trim($payload['email']));

        $investor = InvestorModel::where('is_deleted', 0)
            ->where('registration_step', 3)
            ->where('email', $email)
            ->first();

        if (!$investor) {
            return UtillsHelper::json(0, ['message' => 'No investor registered with this email. Please sign up first.']);
        }

        // Trust Google identity, no MPIN check
        return UtillsHelper::investorLoginResponse($investor, 'Login Success (Google)');
    }

    /**
     * Small helper to reuse mobile lookup logic and avoid redundancy.
     */
    protected function findRegisteredInvestorByMobile(string $mobile, int $countryCode): ?InvestorModel
    {
        return InvestorModel::where('is_deleted', 0)
            ->where('registration_step', 3)
            ->where('mobile_number', $mobile)
            ->where('mobile_country_code', $countryCode)
            ->first();
    }

    /**
     * Simple unique referral code generator.
     */
    // protected function generateUniqueReferralCode(): string
    // {
    //     do {
    //         $code = Str::upper(Str::random(8));
    //     } while (InvestorModel::where('referral_code', $code)->exists());

    //     return $code;
    // }



    /**
     * DEBUG ENDPOINT: Check what's in the Google token payload
     * Remove this in production
     */
    public function debugGoogleToken(Request $request): JsonResponse
    {
        $validation = Validator::make($request->all(), [
            'id_token' => 'required|string',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validation->errors()->first()
            ]);
        }

        $clientId = config('services.google.client_id') ?? env('GOOGLE_CLIENT_ID');
        if (!$clientId) {
            return response()->json([
                'success' => false,
                'error' => 'Google client id not configured on server.'
            ]);
        }

        $googleClient = new Google_Client();
        $googleClient->setClientId($clientId);

        try {
            $payload = $googleClient->verifyIdToken($request->id_token);

            // Check if payload is false, null, or not an array BEFORE using array_keys
            if ($payload === false || $payload === null || !is_array($payload)) {
                return response()->json([
                    'success' => false,
                    'error' => 'Token verification returned false. Possible reasons:',
                    'reasons' => [
                        '1. Client ID mismatch - Token was issued for different client',
                        '2. Token expired (tokens expire in 1 hour)',
                        '3. Invalid token format',
                        '4. Token was revoked'
                    ],
                    'client_id_in_env' => $clientId,
                    'token_preview' => substr($request->id_token, 0, 50) . '...'
                ]);
            }

            return response()->json([
                'success' => true,
                'payload' => $payload,
                'available_fields' => array_keys($payload),
                'client_id_in_env' => $clientId
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Exception during verification: ' . $e->getMessage(),
                'error_type' => get_class($e),
                'error_line' => $e->getLine(),
                'error_file' => basename($e->getFile())
            ]);
        }
    }
}
