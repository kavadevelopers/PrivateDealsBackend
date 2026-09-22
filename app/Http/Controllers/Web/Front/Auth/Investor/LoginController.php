<?php

namespace App\Http\Controllers\Web\Front\Auth\Investor;

use App\Enums\Utills\DeviceTypeEnum;
use App\Helpers\UtillsHelper;
use App\Http\Controllers\Controller;
use App\Models\CoreFirebaseDeviceTokenModel;
use App\Models\InvestorModel;
use App\Repositories\InvestorRepository;
use AWS\CRT\Log;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LoginController extends Controller
{

    private $invRepo;

    function __construct(InvestorRepository $investorRepository)
    {
        $this->invRepo = $investorRepository;
    }

    function index(): View
    {

        setPageTitle('Login');
        addJavascriptFile('front-assets/js/custom/auth/investor/login.js');
        return view('front.investor.auth.login');
    }

    function login(): JsonResponse
    {
        return $this->invRepo->login();
    }

    public function changePassword(Request $request): JsonResponse
    {
        if (!Session::has('investor_login_id')) {
            return UtillsHelper::json(0, ['reset' => true]);
        }

        $investor = InvestorModel::where('id', Session::get('investor_login_id'))->first();
        if (!$investor) {
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

            $investor->password = Hash::make($request->password);
            $investor->ask_password_change = '0';
            $investor->save();

            Session::forget('investor_login_id');
            Auth::guard('investor')->loginUsingId($investor->id);
            return UtillsHelper::json(1, ['message' => 'Login success.']);
        }
    }

    function logout(): RedirectResponse
    {
        return $this->invRepo->logout();
    }
}
