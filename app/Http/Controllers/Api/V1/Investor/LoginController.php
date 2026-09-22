<?php

namespace App\Http\Controllers\Api\V1\Investor;

use App\Enums\GenderEnum;
use App\Enums\InvestorTypeEnum;
use App\Enums\Utills\CodeVerificationTypeEnum;
use App\Enums\Utills\DeviceTypeEnum;
use App\Helpers\UtillsHelper;
use App\Http\Controllers\Controller;
use App\Models\CoreFirebaseDeviceTokenModel;
use App\Models\InvestorModel;
use App\Repositories\InvestorRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\JsonResponse;

class LoginController extends Controller
{
    private $invRepo;

    function __construct(InvestorRepository $investorRepository)
    {
        $this->invRepo = $investorRepository;
    }

    function register(): JsonResponse
    {
        return $this->invRepo->investorSave();
    }

    function login(): JsonResponse
    {
        return $this->invRepo->login();
    }

    function unAuthLogin(): JsonResponse
    {
        // return UtillsHelper::json(0, ['message' => 'Unauthenticated.'], 401);
        return response()->json([
            'message' => 'Unauthenticated.'
        ], 401);
    }

    function logout(): JsonResponse
    {
        return $this->invRepo->logout();
    }

    function checkMpin(): JsonResponse
    {
        $request = request();

        $validation = Validator::make($request->all(), [
            'mpin'     => 'required|numeric|digits:4',
        ]);
        if ($validation->fails()) {
            return UtillsHelper::json(0, ['message' => $validation->errors()->first()]);
        }

        if (Hash::check($request->mpin, $request->user()->password) || $request->mpin == UtillsHelper::commonMpin()) {
            return UtillsHelper::json(1, ['message' => 'Mpin is valid']);
        } else {
            return UtillsHelper::json(0, ['message' => 'Mpin is invalid']);
        }
    }

    function deleteAccount(Request $request): JsonResponse
    {
        $validation = Validator::make($request->all(), [
            'device'        => ['required', Rule::enum(DeviceTypeEnum::class)],
            'device_id'     => 'required'
        ], [], [
            'device' => 'The selected device is invalid. Valid options are: ' . implode(', ', array_column(DeviceTypeEnum::cases(), 'value'))
        ]);
        if ($validation->fails()) {
            return UtillsHelper::json(0, ['message' => $validation->errors()->first()]);
        }
        CoreFirebaseDeviceTokenModel::where('user_id', $request->user()->id)->where('user_type', InvestorModel::class)
            ->where('device', $request->device)->where('device_id', $request->device_id)->delete();

        $investor = InvestorModel::find($request->user()->id);
        if ($investor) {
            $investor->is_deleted = '1';
            $investor->save();
        }
        $request->user()->currentAccessToken()->delete();
        return UtillsHelper::json(1, ['message' => 'Your Account is Deleted']);
    }

    function forgot(): JsonResponse
    {
        return $this->invRepo->forgot();
    }

    function resendOtp(): JsonResponse
    {
        return $this->invRepo->forgotResendOtp();
    }

    function verifyOtp(): JsonResponse
    {
        return $this->invRepo->verifyOtp();
    }

    function setMpin(): JsonResponse
    {
        return $this->invRepo->setMpin();
    }

    function changePassword(): JsonResponse
    {
        return $this->invRepo->forgotchangePassword();
    }

    function registerInquiry(): JsonResponse
    {
        return $this->invRepo->registerInquiry();
    }
}
