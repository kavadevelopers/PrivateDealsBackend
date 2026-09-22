<?php

namespace App\Http\Controllers\Web\Front\Auth\Investor;

use App\Enums\Utills\CodeVerificationTypeEnum;
use App\Helpers\UtillsHelper;
use App\Http\Controllers\Controller;
use App\Models\InvestorModel;
use App\Models\ReportsVerificationCodeModel;
use App\Repositories\InvestorRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;

class PasswordResetController extends Controller
{
    private $invRepo;

    function __construct(InvestorRepository $investorRepository)
    {
        $this->invRepo = $investorRepository;
    }

    function index(): View
    {
        setPageTitle('Forgot Password');
        addJavascriptFile('front-assets/js/custom/auth/investor/forgot.js');
        return view('front.investor.auth.forgot');
    }

    public function forgot(Request $request): JsonResponse
    {
        return $this->invRepo->forgot();
    }

    public function resendOtp(Request $request): JsonResponse
    {
        return $this->invRepo->forgotResendOtp();
    }

    public function verifyOtp(Request $request): JsonResponse
    {
        return $this->invRepo->verifyOtp();
    }

    public function changePassword(Request $request): JsonResponse
    {
        return $this->invRepo->forgotchangePassword();
    }
}
