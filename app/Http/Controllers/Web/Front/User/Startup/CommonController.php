<?php

namespace App\Http\Controllers\Web\Front\User\Startup;

use App\Enums\Utills\StatusEnum;
use App\Http\Controllers\Controller;
use App\Jobs\OfferLetterSendJob;
use App\Models\DocumentsModel;
use App\Models\NotificationsModel;
use App\Models\StartupModel;
use App\Models\StartupOfferRequestModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CommonController extends Controller
{

    function document(): View
    {
        setPageTitle('Document');
        $data['documents'] = DocumentsModel::where('status', '1')->whereJsonContains('meta->startup', Auth::guard('startup')->user()->id)->orderby('id', 'desc');
        return view('front.common.document', $data);
    }

    function notifications(): View
    {
        setPageTitle('Notifications');
        NotificationsModel::where('user_id', Auth::guard('startup')->user()->id)->where('user_type', StartupModel::class)->update(['is_readed' => '1']);
        $data['list'] = NotificationsModel::where('user_id', Auth::guard('startup')->user()->id)->where('user_type', StartupModel::class)->orderby('id', 'desc')->limit(200);
        return view('front.common.notifications', $data);
    }

    function changePassword(): View
    {
        setPageTitle('Change Password');
        return view('front.startup.change-password');
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

        $investor = StartupModel::where('id', Auth::guard('startup')->user()->id)->first();
        $investor->password = Hash::make($request->password);
        $investor->save();

        return redirect()->back()->with('success', 'Password Changed');
    }


    function requestOffer(): RedirectResponse
    {
        $request = new StartupOfferRequestModel();
        $request->startup_id = Auth::guard('startup')->user()->id;
        $request->status = StatusEnum::pending;
        $request->save();

        return redirect()->back()->with('success', 'Offerletter request sent to admin.');
    }

    function sendOffer(): RedirectResponse
    {
        OfferLetterSendJob::dispatch(Auth::guard('startup')->user()->id);
        return redirect()->back()->with('success', 'Offerletter added to queue.');
    }
}
