<?php

namespace App\Http\Controllers\Web\Admin;

use App\Enums\NotificationTypeEnum;
use App\Enums\PaymentStatusEnum;
use App\Enums\PrimaryTransactionPaymentMode;
use App\Enums\Utills\StatusEnum;
use App\Enums\WpMessageTypeEnum;
use App\Helpers\UtillsHelper;
use App\Http\Controllers\Controller;
use App\Models\DocumentsModel;
use App\Models\InvestorModel;
use App\Models\SecondaryPaymentsModel;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SecondaryPaymentReceiptController extends Controller
{
    function pending(): View
    {
        setPageTitle('Secondary Pending Payment Receipt');
        $data['list'] = SecondaryPaymentsModel::where('status', StatusEnum::pending->value)->get();

        return view('admin.pages.investor.paymentreceipt.secondary-list', $data);
    }

    function approved(): View
    {
        setPageTitle('Secondary Completed Payment Receipt');
        $data['list'] = SecondaryPaymentsModel::where('status', StatusEnum::approved->value)->get();
        return view('admin.pages.investor.paymentreceipt.secondary-list', $data);
    }

    function rejected(): View
    {
        setPageTitle('Secondary Completed Payment Receipt');
        $data['list'] = SecondaryPaymentsModel::where('status', StatusEnum::rejected->value)->get();
        return view('admin.pages.investor.paymentreceipt.secondary-list', $data);
    }

    function approve($id)
    {
        $payment = SecondaryPaymentsModel::where('id', $id)->first();
        if ($payment) {
            $payment->update([
                'status' => StatusEnum::approved,
            ]);
            $transaction = $payment->transaction;
            $transaction->status = 3;
            $transaction->save();

            DocumentsModel::where('id', $payment->document_id)->update([
                'status' => 1,
            ]);

            UtillsHelper::sendNotification($transaction->seller->id, InvestorModel::class, 'secondary-transactions', 'Payment Received', 'Payment received in escrow account now you can transfer shares to buyer demat acoount.');
            UtillsHelper::sendNotification($transaction->buyer->id, InvestorModel::class, 'secondary-transactions', 'Payment Received', 'Payment request approved by admin next process will be transfer shares in demat.');

            UtillsHelper::sendWpMessage(
                NotificationTypeEnum::event,
                'notify_seller_payment_received_from_buyer_in_escrow',
                WpMessageTypeEnum::text,
                $transaction->seller->mobile_number,
                $transaction->seller->name,
                NULL,
                [],
                [$transaction->seller->name, $transaction->buyer->name, $transaction->shares * $transaction->share_price, $transaction->shares],
                ['transaction_id' => $transaction->id]
            );

            return redirect()->back()->with('success', 'Payment approved successfully.');
        }

        return redirect()->back()->with('error', 'Payment record not found.');
    }

    function reject($id)
    {

        $payment = SecondaryPaymentsModel::where('id', $id)->first();
        if ($payment) {
            $payment->update([
                'status' => StatusEnum::rejected,
            ]);
            $transaction = $payment->transaction;
            $transaction->status = 2;
            $transaction->save();
            UtillsHelper::sendNotification($transaction->buyer->id, InvestorModel::class, 'secondary-transactions', 'Payment Receipt rejected', 'Payment request rejected by admin please re upload the receipt');

            return redirect()->back()->with('success', 'Payment rejected successfully.');
        }

        return redirect()->back()->with('error', 'Payment record not found.');
    }
}
