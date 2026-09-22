<?php

namespace App\Http\Controllers\Web\Admin;

use App\Helpers\AdminHelper;
use App\Http\Controllers\Controller;
use App\Models\DocumentsModel;
use App\Models\InvestorModel;
use App\Models\PortfolioModel;
use App\Models\PrimaryTransactionModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\DataTables\PrimaryTransactionDataTable;

class PrimaryTransactionController extends Controller
{
    function list(PrimaryTransactionDataTable $dataTable, Request $request)
    {
        addVendor('datatables');
        if ($request->routeIs('admin.primarytransactions.pending')) {
            setPageTitle('Pending Transactions');
            return $dataTable->withStatus('<', 10)->render('admin.pages.transaction.list');
        } elseif ($request->routeIs('admin.primarytransactions.completed')) {
            setPageTitle('Completed Transactions');
            return $dataTable->withStatus('=', 10)->render('admin.pages.transaction.list');
        }
        
        // return view('admin.pages.transaction.list', $data);
    }

    function delete($id): RedirectResponse
    {
        $primaryTransaction = PrimaryTransactionModel::where('id', $id)->first();
        if ($primaryTransaction) {
            if ($primaryTransaction->portfolio_id != NULL) {
                $portfolio = PortfolioModel::where('id', $primaryTransaction->portfolio_id)->first();
                if ($portfolio) {
                    $shares = $portfolio->shares - $primaryTransaction->shares;
                    $portfolio->shares = $shares;
                    $portfolio->investment_amount = $portfolio->shares * $portfolio->purchase_price;
                    $portfolio->save();
                }
            }

            DocumentsModel::whereJsonContains('meta->primary_transactions', $primaryTransaction->id)->delete();

            $primaryTransaction->delete();

            AdminHelper::logPut('Primary Trasaction delete for ' . $primaryTransaction->startup->brand_name, InvestorModel::class, $primaryTransaction->investor_id);
            return redirect()->back()->with('success', 'Transaction deleted');
        }
        return redirect()->back()->with('error', 'Transaction not found');
    }
}
