<?php

namespace App\Repositories\V2;

use App\Enums\Utills\CodeVerificationTypeEnum;
use App\Enums\Utills\DeviceTypeEnum;
use App\Helpers\CommonHelper;
use App\Helpers\FileUpDownHelper;
use App\Helpers\UtillsHelper;
use App\Models\CoreFirebaseDeviceTokenModel;
use App\Models\SellerMasterModel;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\JsonResponse;

class SellerRepository
{
    use FileUploadTrait;

    function login(): JsonResponse
    {
        $request = request();
        $validation = Validator::make($request->all(), [
            'mobile_no' => 'required|numeric|digits:10',
            'password' => 'required',
            'firebase_token' => 'required',
            'device_id' => 'required|string|max:255',
            'device' => ['required', Rule::enum(DeviceTypeEnum::class)],
        ], [], [
            'device' => 'The selected device is invalid. Valid options are: ' . implode(', ', array_column(DeviceTypeEnum::cases(), 'value')),
        ]);
        if ($validation->fails()) {
            return UtillsHelper::json(0, ['message' => $validation->errors()->first()]);
        }

        $seller = SellerMasterModel::where('is_deleted', '0')
            ->where('mobile_number', $request->mobile_no)
            ->first();

        if (!$seller) {
            return UtillsHelper::json(0, ['message' => 'Mobile number not registered.']);
        }

        if (!$seller->password || !Hash::check($request->password, $seller->password)) {
            return UtillsHelper::json(0, ['message' => 'Mobile number and Password do not match.']);
        }

        if ($seller->is_blocked == '1') {
            return UtillsHelper::json(0, ['message' => 'Your account is blocked please contact administrator']);
        }

        $seller->token = $seller->createToken('Seller login token')->plainTextToken;
        UtillsHelper::firebaseLogin($seller->id, SellerMasterModel::class);

        return UtillsHelper::json(1, [
            'message' => 'Login Success',
            'data' => $this->presentSeller($seller),
        ]);
    }

    function logout(): JsonResponse
    {
        $request = request();
        $validation = Validator::make($request->all(), [
            'device' => ['required', Rule::enum(DeviceTypeEnum::class)],
            'device_id' => 'required',
        ], [], [
            'device' => 'The selected device is invalid. Valid options are: ' . implode(', ', array_column(DeviceTypeEnum::cases(), 'value')),
        ]);
        if ($validation->fails()) {
            return UtillsHelper::json(0, ['message' => $validation->errors()->first()]);
        }

        CoreFirebaseDeviceTokenModel::where('user_id', $request->user()->id)
            ->where('user_type', SellerMasterModel::class)
            ->where('device', $request->device)
            ->where('device_id', $request->device_id)
            ->delete();

        $request->user()->currentAccessToken()->delete();

        return UtillsHelper::json(1, [
            'message' => 'Logout Success',
        ]);
    }

    function deleteAccount(): JsonResponse
    {
        $request = request();
        $validation = Validator::make($request->all(), [
            'device' => ['required', Rule::enum(DeviceTypeEnum::class)],
            'device_id' => 'required',
        ], [], [
            'device' => 'The selected device is invalid. Valid options are: ' . implode(', ', array_column(DeviceTypeEnum::cases(), 'value')),
        ]);
        if ($validation->fails()) {
            return UtillsHelper::json(0, ['message' => $validation->errors()->first()]);
        }

        CoreFirebaseDeviceTokenModel::where('user_id', $request->user()->id)
            ->where('user_type', SellerMasterModel::class)
            ->where('device', $request->device)
            ->where('device_id', $request->device_id)
            ->delete();

        $seller = SellerMasterModel::find($request->user()->id);
        if ($seller) {
            $seller->is_deleted = '1';
            $seller->save();
        }

        $request->user()->currentAccessToken()->delete();

        return UtillsHelper::json(1, [
            'message' => 'Your Account is Deleted',
        ]);
    }

    function profile(): JsonResponse
    {
        $request = request();
        $seller = SellerMasterModel::where('id', $request->user()->id)
            ->where('is_deleted', '0')
            ->first();

        if (!$seller) {
            return UtillsHelper::json(0, ['message' => 'Seller not found']);
        }

        return UtillsHelper::json(1, [
            'message' => 'Profile',
            'data' => $this->presentSeller($seller),
        ]);
    }

    function updateProfile(): JsonResponse
    {
        $request = request();
        $validation = Validator::make($request->all(), [
            'logo' => 'required|image|mimes:' . CommonHelper::appSettings('file_image_extensions_allowed') . '|max:' . UtillsHelper::maxFileImageSizeInKB(),
        ]);
        if ($validation->fails()) {
            return UtillsHelper::json(0, ['message' => $validation->errors()->first()]);
        }

        $seller = SellerMasterModel::where('id', $request->user()->id)
            ->where('is_deleted', '0')
            ->first();

        if (!$seller) {
            return UtillsHelper::json(0, ['message' => 'Seller not found']);
        }

        if ($seller->logo && $seller->logo != NULL) {
            $this->deleteFile($seller->logo);
        }

        $seller->logo = FileUpDownHelper::seller_logo_upload($request->file('logo'));
        $seller->save();

        return UtillsHelper::json(1, [
            'message' => 'Profile updated',
            'data' => $this->presentSeller($seller),
        ]);
    }

    public function forgot(): JsonResponse
    {
        $request = request();
        $validation = Validator::make($request->all(), [
            'mobile_no' => 'required|numeric|digits:10',
        ], [], [
            'mobile_no' => 'Mobile number is required',
        ]);
        if ($validation->fails()) {
            return UtillsHelper::json(0, ['message' => $validation->errors()->first()]);
        }

        $seller = SellerMasterModel::where('is_deleted', '0')
            ->where('mobile_number', $request->mobile_no)
            ->first();

        if (!$seller) {
            return UtillsHelper::json(0, ['message' => 'Mobile number not registered.']);
        }

        if ($seller->is_blocked == '1') {
            return UtillsHelper::json(0, ['message' => 'Your account is blocked please contact administrator']);
        }

        UtillsHelper::sendVerificationCode(
            $seller->id,
            SellerMasterModel::class,
            $request->mobile_no,
            CodeVerificationTypeEnum::forgot_password
        );

        return UtillsHelper::json(1, [
            'message' => 'Verification code sent to ' . $request->mobile_no,
            'data' => $this->presentSeller($seller),
        ]);
    }

    public function verifyOtp(): JsonResponse
    {
        $request = request();
        $validation = Validator::make($request->all(), [
            'seller_id' => 'required',
            'otp' => 'required',
        ]);
        if ($validation->fails()) {
            return UtillsHelper::json(0, ['message' => $validation->errors()->first()]);
        }

        $seller = SellerMasterModel::where('id', $request->seller_id)
            ->where('is_deleted', '0')
            ->first();

        if (!$seller) {
            return UtillsHelper::json(0, ['message' => 'Seller not found']);
        }

        $code = UtillsHelper::getVerificationCode(
            $request->otp,
            $seller->id,
            SellerMasterModel::class,
            CodeVerificationTypeEnum::forgot_password
        );

        if (!$code) {
            return UtillsHelper::json(0, ['message' => 'Verification code is not valid']);
        }

        $code->is_used = '1';
        $code->save();

        return UtillsHelper::json(1, ['message' => 'OTP is Verified , Change Your Password']);
    }

    public function resendOtp(): JsonResponse
    {
        $request = request();
        $validation = Validator::make($request->all(), [
            'seller_id' => 'required',
        ]);
        if ($validation->fails()) {
            return UtillsHelper::json(0, ['message' => $validation->errors()->first()]);
        }

        $seller = SellerMasterModel::where('id', $request->seller_id)
            ->where('is_deleted', '0')
            ->first();

        if (!$seller) {
            return UtillsHelper::json(0, ['message' => 'Seller not found']);
        }

        if (!$seller->mobile_number) {
            return UtillsHelper::json(0, ['message' => 'Mobile number not registered.']);
        }

        UtillsHelper::sendVerificationCode(
            $seller->id,
            SellerMasterModel::class,
            $seller->mobile_number,
            CodeVerificationTypeEnum::forgot_password
        );

        return UtillsHelper::json(1, [
            'message' => 'Verification code sent to ' . $seller->mobile_number,
        ]);
    }

    public function changePassword(): JsonResponse
    {
        $request = request();
        $validation = Validator::make($request->all(), [
            'seller_id' => 'required',
            'password' => 'required|string|min:6',
        ]);
        if ($validation->fails()) {
            return UtillsHelper::json(0, ['message' => $validation->errors()->first()]);
        }

        $seller = SellerMasterModel::where('id', $request->seller_id)
            ->where('is_deleted', '0')
            ->first();

        if (!$seller) {
            return UtillsHelper::json(0, ['message' => 'Seller not found']);
        }

        $seller->password = Hash::make($request->password);
        $seller->ask_password_change = '0';
        $seller->save();

        return UtillsHelper::json(1, ['message' => 'Password reset success.']);
    }

    private function presentSeller(SellerMasterModel $seller): SellerMasterModel
    {
        $seller->setAttribute('logo', FileUpDownHelper::get_seller_logo_url($seller));

        return $seller;
    }
}
