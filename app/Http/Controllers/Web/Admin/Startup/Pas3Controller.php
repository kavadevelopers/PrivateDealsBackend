<?php

namespace App\Http\Controllers\Web\Admin\Startup;

use App\Http\Controllers\Controller;
use App\Models\StartupModel;
use App\Models\StartupPas3Model;
use App\Enums\StartupPas3Enum;
use App\Enums\Utills\StatusEnum;
use App\Helpers\UtillsHelper;
use App\Models\PrimaryTransactionModel;
use App\Models\PrimaryTransactionPas3Model;
use Illuminate\Http\Request;
use Illuminate\View\View;

class Pas3Controller extends Controller
{
    function pending(): View
    {
        setPageTitle('Pending PAS3');
        $data['list']    = PrimaryTransactionPas3Model::where('status', StatusEnum::pending->value)->orderby('id', 'asc')->with(['startup', 'zipDocument'])->limit(200)->get();
        return view('admin.pages.startup.pass3.list', $data);
    }

    function approved(): View
    {
        setPageTitle('Approved MGT14');
        $data['list']    = PrimaryTransactionPas3Model::where('status', StatusEnum::approved->value)->orderby('id', 'asc')->with(['startup', 'zipDocument'])->limit(200)->get();
        return view('admin.pages.startup.pass3.list', $data);
    }

    function rejected(): View
    {
        setPageTitle('Rejected MGT14');
        $data['list']    = PrimaryTransactionPas3Model::where('status', StatusEnum::rejected->value)->orderby('id', 'asc')->with(['startup', 'zipDocument'])->limit(200)->get();
        return view('admin.pages.startup.pass3.list', $data);
    }

    function approve($id)
    {
        $pas = PrimaryTransactionPas3Model::where('id', $id)->first();
        if ($pas) {
            foreach ($pas->meta->primary_transactions as $value) {
                $transaction = PrimaryTransactionModel::where('id', $value)->first();
                if ($transaction) {
                    $portfolioId = UtillsHelper::primaryToPortfolio($transaction);
                    $transaction->status = 8;
                    $transaction->pas3_id = $pas->id;
                    $transaction->portfolio_id = $portfolioId;
                    $transaction->save();
                }
            }
            $pas->status = StatusEnum::approved;
            $pas->save();

            $zip = $pas->zipDocument;
            $zip->status = 1;
            $zip->save();

            return redirect()->back()->with('success', 'MGT-14 approved.');
        }
    }

    function reject($id)
    {
        $pas = PrimaryTransactionPas3Model::where('id', $id)->first();
        if ($pas) {
            $pas->status = StatusEnum::rejected;
            $pas->save();
            $zip = $pas->zipDocument;
            $zip->status = 0;
            $zip->save();
            return redirect()->back()->with('success', 'PAS3 rejected.');
        }

        return redirect()->back()->with('error', 'PAS3 not found.');
    }
}
