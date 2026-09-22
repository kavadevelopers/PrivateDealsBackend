<?php

namespace App\Http\Controllers\Web\Admin\Startup;

use App\Http\Controllers\Controller;
use App\Models\StartupModel;
use App\Models\StartupMgt14Model;
use App\Enums\Utills\StatusEnum;
use App\Models\PrimaryTransactionMgt14Model;
use App\Models\PrimaryTransactionModel;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class MGT14Controller extends Controller
{
    function pending(): View
    {
        setPageTitle('Pending MGT14');
        $data['list']    = PrimaryTransactionMgt14Model::where('status', StatusEnum::pending->value)->orderby('id', 'asc')->with(['startup', 'zipDocument', 'challanDocument'])->limit(200)->get();
        return view('admin.pages.startup.mgt14.list', $data);
    }

    function approved(): View
    {
        setPageTitle('Approved MGT14');
        $data['list'] = PrimaryTransactionMgt14Model::with(['startup'])
            ->where('status', 'approved')
            ->whereHas('startup', function ($query) {
                $query->where('is_deleted', '0');
            })
            ->get();
        return view('admin.pages.startup.mgt14.list', $data);
    }

    function rejected(): View
    {
        setPageTitle('Rejected MGT14');
        $data['list'] = PrimaryTransactionMgt14Model::with(['startup'])
            ->where('status', 'rejected')
            ->whereHas('startup', function ($query) {
                $query->where('is_deleted', '0');
            })
            ->get();
        return view('admin.pages.startup.mgt14.list', $data);
    }

    function approve($id): RedirectResponse
    {
        $mgt = PrimaryTransactionMgt14Model::where('id', $id)->first();
        if ($mgt) {
            foreach ($mgt->meta->primary_transactions as $value) {
                PrimaryTransactionModel::where('id', $value)->update([
                    'status' => '4',
                    'mgt14_id'  => $mgt->id
                ]);
            }
            $mgt->status = StatusEnum::approved;
            $mgt->save();
            $zip = $mgt->zipDocument;
            $zip->status = 1;
            $zip->save();
            $chalan = $mgt->challanDocument;
            $chalan->status = 1;
            $chalan->save();
            return redirect()->back()->with('success', 'MGT-14 approved.');
        }

        return redirect()->back()->with('error', 'MGT-14 not found.');
    }

    function reject($id): RedirectResponse
    {
        $mgt = PrimaryTransactionMgt14Model::where('id', $id)->first();
        if ($mgt) {
            $mgt->status = StatusEnum::rejected;
            $mgt->save();
            $zip = $mgt->zipDocument;
            $zip->status = 0;
            $zip->save();
            $chalan = $mgt->challanDocument;
            $chalan->status = 0;
            $chalan->save();
            return redirect()->back()->with('success', 'MGT-14 rejected.');
        }

        return redirect()->back()->with('error', 'MGT-14 not found.');
    }
}
