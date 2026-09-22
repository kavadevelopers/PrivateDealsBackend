<?php

namespace App\Http\Controllers\Web\Front\User\Investor;

use App\Helpers\DigioHelper;
use App\Http\Controllers\Controller;
use App\Helpers\UtillsHelper;
use App\Helpers\FileUpDownHelper;
use App\Models\DocumentsModel;
use App\Models\InvestorModel;
use App\Models\NotificationsModel;
use App\Models\InvestorKycModel;
use App\Models\InvestorFavStartupModel;
use App\Enums\Utills\StatusEnum;
use App\Helpers\DateTimeHelper;
use App\Models\MasterCityModel;
use App\Repositories\InvestorRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CommonController extends Controller
{

    private $invRepo;

    function __construct(InvestorRepository $investorRepository)
    {
        $this->invRepo = $investorRepository;
    }

    function document(): View
    {
        setPageTitle('Document');
        $data['documents'] = $this->invRepo->getDocuments();
        return view('front.common.document', $data);
    }

    function notifications(): View
    {
        setPageTitle('Notifications');
        $data['list'] = $this->invRepo->getNotifications();
        return view('front.common.notifications', $data);
    }

    function dematDetails(): View
    {
        setPageTitle('Demat Account Details');
        $data['investor'] = $this->invRepo->getDemat();
        return view('front.investor.demat-account', $data);
    }

    function dematDetailsSave(): RedirectResponse
    {
        return $this->invRepo->saveDemat();
    }

    function changePassword(): View
    {
        setPageTitle('Change Password');
        return view('front.investor.change-password');
    }

    function changePasswordSave(): RedirectResponse
    {
        return $this->invRepo->changePassword();
    }

    function markstartupfavourite()
    {
        return $this->invRepo->postFavorite();
    }

    public function favouriteStartups(): View
    {
        setPageTitle('Favourites');
        $data['favlist']    = $this->invRepo->getFavorite();
        return view('front.investor.favorites', $data);
    }
    public function investorKyc(): View
    {

        addJavascriptFile('front-assets/js/custom/auth/investor/e-kyc.js');
        $investor = InvestorModel::where('id', Auth::guard('investor')->user()->id)->first();
        if ($investor->preipo_kyc_status == 0) {
            setPageTitle('Complete your KYC');
        } else {
            setPageTitle('KYC Completed');
        }
        $data['investor'] = $investor;
        return view('front.investor.kyc', $data);
    }

    function investorKycSave(): RedirectResponse
    {
        return $this->invRepo->postManualKYC();
    }

    function getEkycToken(): JsonResponse
    {
        return $this->invRepo->getEkycToken();
    }

    function getEkycData(): JsonResponse
    {
        return $this->invRepo->getEkycData();
    }

    function uploadPaymentReceipt(): RedirectResponse
    {
        return $this->invRepo->uploadPaymentReceipt();
    }
}
