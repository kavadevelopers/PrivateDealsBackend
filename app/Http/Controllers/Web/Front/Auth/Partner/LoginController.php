<?php

namespace App\Http\Controllers\Web\Front\Auth\Partner;

use App\Helpers\UtillsHelper;
use App\Http\Controllers\Controller;
use App\Models\InvestorModel;
use App\Models\PartnerModel;
use App\Repositories\PartnerRepository;
use AWS\CRT\Log;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

class LoginController extends Controller
{

    private $partnerRepo;

    function __construct(PartnerRepository $partnerRepository)
    {
        $this->partnerRepo = $partnerRepository;
    }

    function index(): View
    {

        setPageTitle('Business Login');
        addJavascriptFile('front-assets/js/custom/auth/partner/login.js');
        return view('front.partner.auth.login');
    }

    function action(Request $request): JsonResponse
    {
        return $this->partnerRepo->login();
    }

    public function changePassword(Request $request): JsonResponse
    {
        if (!Session::has('partner_login_id')) {
            return UtillsHelper::json(0, ['reset' => true]);
        }

        $partner = PartnerModel::where('id', Session::get('partner_login_id'))->first();
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
            $partner->ask_password_change = '0';
            $partner->save();

            Session::forget('partner_login_id');
            Auth::guard('partner')->loginUsingId($partner->id);
            return UtillsHelper::json(1, ['message' => 'Login Success']);
        }
    }

    function logout(): RedirectResponse
    {
        return $this->partnerRepo->logout();
    }
}
