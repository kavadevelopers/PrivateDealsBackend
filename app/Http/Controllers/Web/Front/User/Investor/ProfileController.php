<?php

namespace App\Http\Controllers\Web\Front\User\Investor;

use App\Helpers\FileUpDownHelper;
use App\Http\Controllers\Controller;
use App\Models\InvestorCompanyDetailsModel;
use App\Models\InvestorDetailsModel;
use App\Models\InvestorKycModel;
use App\Models\InvestorModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ProfileController extends Controller
{
    //
    function profileView(): View
    {
        setPageTitle('Profile');
        $data['list'] = InvestorModel::where('id', Auth::guard('investor')->user()->id)->first();
        return view('front.investor.profile', $data);
    }

    function profileViewSave(Request $request): RedirectResponse
    {

        $investorId = Auth::guard('investor')->user()->id;

        $investor = InvestorModel::firstOrNew(['id' => $investorId]);
        $investor->profile_visibility = $request->visibility;
        $investor->email = $request->email;
        $investor->address = $request->address;
        $investor->pincode = $request->pin;
        $investor->save();

        $investordetils = InvestorDetailsModel::firstOrNew(['investor_id' => $investorId]);

        $investordetils->investor_company =  $request->company;
        $investordetils->investor_company_position =  $request->position;
        $investordetils->investor_bio =  $request->bio;
        $investordetils->facebook_link =  $request->fb;
        $investordetils->twitter_link =  $request->twitter;
        $investordetils->instagram_link =  $request->insta;
        $investordetils->linked_in_link =  $request->linkedin;
        $investordetils->website_link =  $request->web;
        $investordetils->save();


        $message = $investor->wasRecentlyCreated ? 'Profile Created' : 'Profile Updated';
        $message = $investordetils->wasRecentlyCreated ? 'Profile Created' : 'Profile Updated';

        return redirect()->back()->with('success', $message);
    }

    function profileImageSave(Request $request): RedirectResponse
    {
        $logo = FileUpDownHelper::investor_profile_photo_upload($request->file('image'));

        if ($logo) {
            InvestorModel::updateOrCreate(
                ['id' => Auth::guard('investor')->user()->id],
                ['profile_photo' => $logo]
            );
        }

        return redirect()->back();
    }


    public function profileRemoveImage(): RedirectResponse
    {
        $investorId = Auth::guard('investor')->id();
        $investor = InvestorModel::find($investorId);
        if ($investor) {
            $investor->update([
                'profile_photo' => ''
            ]);
        }
        return redirect()->back()->with('success', 'Profile Image Removed');
    }
}
