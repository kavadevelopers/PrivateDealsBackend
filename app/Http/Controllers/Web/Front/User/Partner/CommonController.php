<?php

namespace App\Http\Controllers\Web\Front\User\Partner;

use App\Http\Controllers\Controller;
use App\Models\DocumentsModel;
use App\Models\InvestorModel;
use App\Models\NotificationsModel;
use App\Models\PartnerModel;
use App\Repositories\PartnerRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CommonController extends Controller
{
    private $partnerRepo;

    function __construct(PartnerRepository $partnerRepository)
    {
        $this->partnerRepo = $partnerRepository;
    }
    function document(): View
    {
        return $this->partnerRepo->documents();
    }

    function notifications(): View
    {
        return $this->partnerRepo->notifications();
    }

    function profile(): View
    {
        return $this->partnerRepo->profile();
    }

    function profileSave(Request $request): RedirectResponse
    {
        return $this->partnerRepo->profileSave();
    }

    function changePasswordSave(Request $request): RedirectResponse
    {
        $validation = Validator::make($request->all(), [
            'password'  => 'required',
            'cpassword' => 'required'
        ], [], [
            'password'                                  => 'Password is required',
            'cpassword'                                 => 'Confirm Password is required'
        ]);
        if ($validation->fails()) {
            return redirect()->back()->with('error', $validation->errors()->first());
        }

        $partner = PartnerModel::where('id', Auth::guard('partner')->user()->id)->first();
        $partner->password = Hash::make($request->password);
        $partner->save();

        return redirect()->back()->with('success', 'Password Changed');
    }
}
