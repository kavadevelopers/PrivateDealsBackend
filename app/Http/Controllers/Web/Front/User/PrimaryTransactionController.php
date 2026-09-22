<?php

namespace App\Http\Controllers\Web\Front\User;

use App\Http\Controllers\Controller;
use App\Models\PrimaryTransactionModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PrimaryTransactionController extends Controller
{
    function list(): View
    {
        setPageTitle('Primary Transaction');
        if (Auth::guard('investor')->check()) {
            $data['transactionlist'] = PrimaryTransactionModel::where('investor_id', Auth::guard('investor')->user()->id);
        } else if (Auth::guard('startup')->check()) {
            $data['transactionlist'] = PrimaryTransactionModel::where('startup_id', Auth::guard('startup')->user()->id);
        } else if (Auth::guard('partner')->check()) {
            $data['transactionlist'] = PrimaryTransactionModel::whereHas('investor', function ($query) {
                $query->where('partner_id', Auth::guard('partner')->user()->id);
            });
        }
        return view('front.common.transaction', $data);
    }
}
