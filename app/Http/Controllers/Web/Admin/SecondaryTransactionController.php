<?php

namespace App\Http\Controllers\Web\Admin;

use App\DataTables\SecondaryTransactionDataTable;
use App\Http\Controllers\Controller;
use App\Models\SecondarySellRequestModel;
use App\Models\SecondaryTransactionModel;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SecondaryTransactionController extends Controller
{
    public function list(SecondaryTransactionDataTable $dataTable, Request $request)
    {
        addVendor('datatables');

        if ($request->routeIs('admin.secondarytransactions.pending')) {
            setPageTitle('Pending Transactions');
            return $dataTable->withStatus('<', 8)->render('admin.pages.transaction.secondary.list');
        } elseif ($request->routeIs('admin.secondarytransactions.completed')) {
            setPageTitle('Completed Transactions');
            return $dataTable->withStatus('=', 8)->render('admin.pages.transaction.secondary.list');
        }
    }

    function sellRequestList(Request $request): View
    {
        if ($request->routeIs('admin.secondarySellRequest.pending')) {
            setPageTitle('Pending Sell Requests');
            addVendor('datatables');
            $data['sellRequestlist'] = SecondarySellRequestModel::where('status', '=', '0')->with(['investor','startup'])->get();
        }
        if ($request->routeIs('admin.secondarySellRequest.inProgress')) {
            setPageTitle('InProgress Sell Requests');
            $data['sellRequestlist'] = SecondarySellRequestModel::whereBetween('status', [3, 8])
            ->with(['investor','startup'])->get();
        }
        if ($request->routeIs('admin.secondarySellRequest.completed')) {
            setPageTitle('Completed Sell Requests');
            $data['sellRequestlist'] = SecondarySellRequestModel::where('status', '=', '9')->with(['investor','startup'])->get();
        }
        addVendor('datatables');
        return view('admin.pages.transaction.secondary.sell-request-list', $data);
    }

    function delete(string $id): RedirectResponse
    {
        $item = SecondarySellRequestModel::find($id);

        if ($item) {
            $item->delete();
            return redirect()->route('admin.secondarySellRequest.pending')
                ->with('success', 'Sell Request Deleted.');
        }

        return redirect()->route('admin.secondarySellRequest.pending')->with('error', 'Item not found');
    }
}
