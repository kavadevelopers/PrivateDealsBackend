<?php

namespace App\Http\Controllers\Web\Front\User\Startup;

use App\Enums\NotificationTypeEnum;
use App\Enums\WpMessageTypeEnum;
use App\Helpers\SecondaryTransactionHelper;
use App\Helpers\UtillsHelper;
use App\Http\Controllers\Controller;
use App\Models\InvestorModel;
use App\Models\SecondarySellRequestModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SecondaryController extends Controller
{
    function sellRequest(): View
    {
        setPageTitle("Sell Requests");
        $data['list'] = SecondarySellRequestModel::where('startup_id', Auth::guard('startup')->user()->id)->orderby('id', 'desc');
        return view("front.startup.secondary.sell-request", $data);
    }

    function status($request, $status): RedirectResponse
    {

        $request = SecondarySellRequestModel::where('id', $request)->first();
        if ($request) {

            if ($status == 1) {
                $request->status = 1;
                $request->save();

                SecondaryTransactionHelper::sendShareRequest($request);

                UtillsHelper::sendNotification($request->investor->id, InvestorModel::class, 'sell-request', 'Sell Request', 'Sell Request approved from startup. First buy request sent to promoters');

                UtillsHelper::sendWpMessage(
                    NotificationTypeEnum::event,
                    'startup_approve_reject_notification_to_investor',
                    WpMessageTypeEnum::text,
                    $request->investor->mobile_number,
                    $request->investor->name,
                    NULL,
                    [],
                    [$request->investor->name, $request->shares, $request->price, 'Accepted'],
                    ['sell_request_id' => $request->id]
                );

                return redirect()->back()->with('success', 'Sell Request Approved');
            }

            if ($status == 2) {
                $request->status = 2;
                $request->save();

                UtillsHelper::sendNotification($request->investor->id, InvestorModel::class, 'sell-request', 'Sell Request', 'Sell Request rejected from startup');
                UtillsHelper::sendWpMessage(
                    NotificationTypeEnum::event,
                    'startup_approve_reject_notification_to_investor',
                    WpMessageTypeEnum::text,
                    $request->investor->mobile_number,
                    $request->investor->name,
                    NULL,
                    [],
                    [$request->investor->name, $request->shares, $request->price, 'Rejected'],
                    ['sell_request_id' => $request->id]
                );

                return redirect()->back()->with('success', 'Sell Request Rejected');
            }
        }
        return redirect()->back()->with('error', 'Sell Request not found');
    }
}
