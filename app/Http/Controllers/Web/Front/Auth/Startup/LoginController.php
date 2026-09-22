<?php

namespace App\Http\Controllers\Web\Front\Auth\Startup;

use App\Helpers\UtillsHelper;
use App\Http\Controllers\Controller;
use App\Models\StartupModel;
use App\Repositories\StartupRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LoginController extends Controller
{

    private $startupRepo;

    function __construct(StartupRepository $startupRepository)
    {
        $this->startupRepo = $startupRepository;
    }

    function index(): View
    {
        setPageTitle('Startup Login');
        addJavascriptFile('front-assets/js/custom/auth/startup/login.js');
        return view('front.startup.auth.login');
    }

    function action(Request $request): JsonResponse
    {
        return $this->startupRepo->login();
    }

    public function changePassword(Request $request): JsonResponse
    {
        if (!Session::has('startup_login_id')) {
            return UtillsHelper::json(0, ['reset' => true]);
        }

        $startup = StartupModel::where('id', Session::get('startup_login_id'))->first();
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
            $startup->ask_password_change = '0';
            $startup->save();

            Session::forget('startup_login_id');
            Auth::guard('startup')->loginUsingId($startup->id);
            return UtillsHelper::json(1, ['message' => 'Login Success']);
        }
    }

    function logout(): RedirectResponse
    {
        return $this->startupRepo->logout();
    }
}
