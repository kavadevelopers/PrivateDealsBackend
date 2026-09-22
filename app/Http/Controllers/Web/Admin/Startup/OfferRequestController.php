<?php

namespace App\Http\Controllers\Web\Admin\Startup;

use App\Http\Controllers\Controller;
use App\Models\PrimaryTransactionModel;
use App\Enums\Utills\StatusEnum;
use App\Models\StartupOfferRequestModel;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class OfferRequestController extends Controller
{
    function pending(): View
    {
        setPageTitle('Pending Offer Request');
        $data['list'] = StartupOfferRequestModel::where('status', StatusEnum::pending->value)->get();
        return view('admin.pages.startup.offerrequest.list', $data);
    }

    function approved(): View
    {
        setPageTitle('Rejected Offer Request');
        $data['list'] = StartupOfferRequestModel::where('status', StatusEnum::approved->value)->get();
        return view('admin.pages.startup.offerrequest.list', $data);
    }

    function rejected(): View
    {
        setPageTitle('Rejected Offer Request');
        $data['list'] = StartupOfferRequestModel::where('status', StatusEnum::rejected->value)->get();
        return view('admin.pages.startup.offerrequest.list', $data);
    }

    function approve($id): View|RedirectResponse
    {
        $offer = StartupOfferRequestModel::where('id', $id)->first();
        if ($offer) {
            setPageTitle('Approve Offer Request');
            $data['transactions'] = PrimaryTransactionModel::where('status', '4')
                ->where('startup_id', $offer->startup->id)
                ->get();
            $data['item']   = $offer;
            return view('admin.pages.startup.offerrequest.approve', $data);
        }
        return redirect()->back()->with('error', 'Offeletter record not found.');
    }

    function reject($id): RedirectResponse
    {

        $offer = StartupOfferRequestModel::where('id', $id)->first();

        if ($offer) {
            $offer->update([
                'status' => StatusEnum::rejected,
            ]);
            return redirect()->back()->with('success', 'Offerletter rejected successfully.');
        }

        return redirect()->back()->with('error', 'Offeletter record not found.');
    }

    function approveSave(Request $request): RedirectResponse
    {
        $offer = StartupOfferRequestModel::where('id', $request->item_id)->first();
        if ($offer) {
            $offer->update([
                'status' => StatusEnum::approved,
            ]);
            $other = $offer->startup->StartupOtherOne;
            $other->offer_id = $request->offer_id;
            $other->offer_sign_coordinates = $request->offer_sign_coordinates;
            $other->save();

            foreach ($request->transaction as $key => $value) {
                PrimaryTransactionModel::where('id', $value)->update([
                    'offerletterno' => $request->serial_no[$key]
                ]);
            }

            return redirect()->back()->with('success', 'Offerletter rejected successfully.');
        }

        return redirect()->back()->with('error', 'Offeletter record not found.');
    }
}
