<?php

namespace App\Http\Controllers\Api;

use App\Enums\Utills\DeviceTypeEnum;
use App\Helpers\UtillsHelper;
use App\Http\Controllers\Controller;
use App\Models\CoreFirebaseDeviceTokenModel;
use App\Models\InvestorModel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

class GuestDeviceTokenController extends Controller
{
    /**
     * Store / update FCM token for a guest or authenticated user.
     *
     * Called on app open (guest) OR when FCM auto-rotates the token.
     *
     * - Guest user   : omit user_id → keyed by device_id + user_id=null
     * - Logged-in    : pass user_id  → keyed by device_id + user_id
     */
    public function store(Request $request): JsonResponse
    {
        $validation = Validator::make($request->all(), [
            'device'    => ['required', Rule::enum(DeviceTypeEnum::class)],
            'device_id' => 'required|string|max:255',
            'token'     => 'required|string|max:255',
            'version'   => 'nullable|string|max:50',
            'user_id'   => 'nullable|integer',
        ], [
            'device.required'    => 'The device field is required.',
            'device.enum'        => 'Invalid device type. Valid options are: ' . implode(', ', array_column(DeviceTypeEnum::cases(), 'value')),
            'device_id.required' => 'The device_id field is required.',
            'token.required'     => 'The firebase token is required.',
        ]);

        if ($validation->fails()) {
            return UtillsHelper::json(0, ['message' => $validation->errors()->first()]);
        }

        $userId = $request->user_id ? (int) $request->user_id : null;

        // Map 'token' → 'firebase_token' so firebaseLogin() reads the correct field.
        $request->merge(['firebase_token' => $request->token]);

        UtillsHelper::firebaseLogin($userId, InvestorModel::class);

        return UtillsHelper::json(1, ['message' => 'Data saved successfully']);
    }
}
