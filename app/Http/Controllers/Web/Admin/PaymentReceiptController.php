<?php

namespace App\Http\Controllers\Web\Admin;

use App\Enums\PaymentStatusEnum;
use App\Enums\PrimaryTransactionPaymentMode;
use App\Http\Controllers\Controller;
use App\Models\DocumentsModel;
use App\Models\PrimaryTransactionPaymentModel;
use App\Models\StartupDocumentModel;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PaymentReceiptController extends Controller
{
    function pending(): View
    {
        setPageTitle('Pending Payment Receipt');
        $data['list'] = PrimaryTransactionPaymentModel::where('status', PaymentStatusEnum::pending->value)->wherein('type', [PrimaryTransactionPaymentMode::rtgs->value, PrimaryTransactionPaymentMode::cheque->value])->get();
        return view('admin.pages.investor.paymentreceipt.list', $data);
    }

    function approved(): View
    {
        setPageTitle('Completed Payment Receipt');
        $data['list'] = PrimaryTransactionPaymentModel::where('status', PaymentStatusEnum::completed->value)->wherein('type', [PrimaryTransactionPaymentMode::rtgs->value, PrimaryTransactionPaymentMode::cheque->value])->get();
        return view('admin.pages.investor.paymentreceipt.list', $data);
    }

    function rejected(): View
    {
        setPageTitle('Completed Payment Receipt');
        $data['list'] = PrimaryTransactionPaymentModel::where('status', PaymentStatusEnum::rejected->value)->wherein('type', [PrimaryTransactionPaymentMode::rtgs->value, PrimaryTransactionPaymentMode::cheque->value])->get();
        return view('admin.pages.investor.paymentreceipt.list', $data);
    }

    function approve($id): RedirectResponse
    {
        $payment = PrimaryTransactionPaymentModel::where('id', $id)->first();
        if ($payment) {
            $payment->update([
                'status' => PaymentStatusEnum::completed,
            ]);
            $transaction = $payment->primaryTransaction;
            $transaction->payment_status = 1;
            $transaction->status = 7;
            $transaction->save();

            DocumentsModel::where('id', $payment->document_id)->update([
                'status' => 1,
            ]);

            return redirect()->back()->with('success', 'Payment approved successfully.');
        }

        return redirect()->back()->with('error', 'Payment record not found.');
    }

    function reject($id): RedirectResponse
    {

        $payment = PrimaryTransactionPaymentModel::where('id', $id)->first();
        if ($payment) {
            $payment->update([
                'status' => PaymentStatusEnum::rejected,
            ]);

            return redirect()->back()->with('success', 'Payment rejected successfully.');
        }

        return redirect()->back()->with('error', 'Payment record not found.');
    }
}
