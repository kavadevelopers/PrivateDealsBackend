<?php

namespace App\Http\Controllers\Web\Admin\Auth;

use App\Enums\Utills\DeviceTypeEnum;
use App\Http\Requests\auth\AdminLoginRequest;
use App\Helpers\AdminHelper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\CoreFirebaseDeviceTokenModel;
use App\Models\UserAdminModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    //
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        setPageTitle('Login');
        addJavascriptFile('assets/js/custom/authentication/sign-in/general.js');
        return view('admin.pages.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\AdminLoginRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AdminLoginRequest $request): RedirectResponse
    {


        $request->authenticate();

        $request->session()->regenerate();

        // $request->user()->update([
        //     'last_login_at' => Carbon::now()->toDateTimeString(),
        //     'last_login_ip' => $request->getClientIp()
        // ]);

        return redirect()->intended(AdminHelper::url('dashboard'));
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {

        if (Auth::guard('admin')->check()) {
            CoreFirebaseDeviceTokenModel::where('user_id', Auth::guard('admin')->user()->id)->where('user_type', UserAdminModel::class)
                ->where('device', DeviceTypeEnum::web)->where('device_id', Cookie::get('_unique_device_id'))->delete();
            Auth::guard('admin')->logout();
        }


        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(AdminHelper::url('dashboard'));
    }
}
