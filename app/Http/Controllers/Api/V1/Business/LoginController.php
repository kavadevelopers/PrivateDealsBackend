<?php

namespace App\Http\Controllers\Api\V1\Business;

use App\Enums\Utills\DeviceTypeEnum;
use App\Helpers\UtillsHelper;
use App\Http\Controllers\Controller;
use App\Models\CoreFirebaseDeviceTokenModel;
use App\Models\PartnerModel;
use App\Repositories\PartnerRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\JsonResponse;

class LoginController extends Controller
{
    private $partnerRepo;

    function __construct(PartnerRepository $partnerRepository)
    {
        $this->partnerRepo = $partnerRepository;
    }

    function login(): JsonResponse
    {
        return $this->partnerRepo->login();
    }

    function logout(): JsonResponse
    {
        return $this->partnerRepo->logout();
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

        CoreFirebaseDeviceTokenModel::where('user_id', $request->user()->id)->where('user_type', PartnerModel::class)
            ->where('device', $request->device)->where('device_id', $request->device_id)->delete();
        $partner = PartnerModel::find($request->user()->id);
        if ($partner) {
            $partner->is_deleted = '1';
            $partner->save();
        }
        $request->user()->currentAccessToken()->delete();
        return UtillsHelper::json(1, ['message' => 'Your Account is Deleted']);
    }

    function dashboard(Request $request): JsonResponse
    {
        return UtillsHelper::json(1, ['res' => $request->user()]);
    }
}
