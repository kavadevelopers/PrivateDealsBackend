<?php

namespace App\Repositories;

use App\Enums\Utills\DeviceTypeEnum;
use App\Helpers\UtillsHelper;
use App\Models\CoreFirebaseDeviceTokenModel;
use App\Models\StartupModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;

class StartupRepository
{

    function getActiveStartups(): Collection
    {
        return StartupModel::where('registration_step', '6')->where('is_deleted', '0')->get();
    }

    function login(): JsonResponse
    {
        $request = request();
        $validateArray = [
            'mobile_no' => 'required|numeric|digits:10',
            'password'  => 'required'
        ];
        $messageArray = [];
        if ($request->is('api/*')) {
            $validateArray['firebase_token'] = 'required';
            $validateArray['device_id'] = 'required|string|max:255';
            $validateArray['device'] = ['required', Rule::enum(DeviceTypeEnum::class)];

            $messageArray['device'] = 'The selected device is invalid. Valid options are: ' . implode(', ', array_column(DeviceTypeEnum::cases(), 'value'));
        }
        $validation = Validator::make($request->all(), $validateArray, [], $messageArray);
        if ($validation->fails()) {
            return UtillsHelper::json(0, ['message' => $validation->errors()->first()]);
        }

        $startup = StartupModel::where('is_deleted', '0')->where('registration_step', '6')->where('mobile_number', $request->mobile_no)->first();
        if (!$startup) {
            return UtillsHelper::json(0, ['message' => 'Mobile number not registered.']);
        } else {
            if (!Hash::check($request->password, $startup->password)) {
                return UtillsHelper::json(0, ['message' => 'Mobile number and Password do not match.']);
            } else {
                if ($startup->is_blocked == '1') {
                    return UtillsHelper::json(0, ['message' => 'Your account is blocked please contact administrator']);
                } else {
                    if ($request->is('api/*')) {
                        $startup->token = $startup->createToken('Startup login token')->plainTextToken;
                        UtillsHelper::firebaseLogin($startup->id, StartupModel::class);
                        return UtillsHelper::json(1, [
                            'message' => 'Login Success',
                            'data'  => $startup
                        ]);
                    }
                    if ($startup->ask_password_change == '1') {
                        Session::put('startup_login_id', $startup->id);
                        return UtillsHelper::json(1, ['view' => view('front.common.auth.change-password', [
                            'title' => 'Change your password',
                            'action'    => route('front.raise.auth.post.login.password'),
                            'redirect'  => route('front.raise.auth.login')
                        ])->render()]);
                    } else {
                        Auth::guard('startup')->loginUsingId($startup->id);
                        UtillsHelper::firebaseLogin($startup->id, StartupModel::class);
                        return UtillsHelper::json(1, ['message' => 'Login Success']);
                    }
                }
            }
        }
    }

    function logout(): RedirectResponse|JsonResponse
    {
        $request = request();
        if ($request->is('api/*')) {
            $validation = Validator::make($request->all(), [
                'device'        => ['required', Rule::enum(DeviceTypeEnum::class)],
                'device_id'     => 'required'
            ], [], [
                'device' => 'The selected device is invalid. Valid options are: ' . implode(', ', array_column(DeviceTypeEnum::cases(), 'value'))
            ]);
            if ($validation->fails()) {
                return UtillsHelper::json(0, ['message' => $validation->errors()->first()]);
            }
            CoreFirebaseDeviceTokenModel::where('user_id', $request->user()->id)->where('user_type', StartupModel::class)
                ->where('device', $request->device)->where('device_id', $request->device_id)->delete();
            $request->user()->currentAccessToken()->delete();
            return UtillsHelper::json(1, [
                'message' => 'Logout Success'
            ]);
        } else {
            if (Auth::guard('startup')->check()) {
                CoreFirebaseDeviceTokenModel::where('user_id', Auth::guard('startup')->user()->id)->where('user_type', StartupModel::class)
                    ->where('device', DeviceTypeEnum::web)->where('device_id', Cookie::get('_unique_device_id'))->delete();
                Auth::guard('startup')->logout();
            }
            return redirect()->route('front.raise.auth.login');
        }
    }
}
