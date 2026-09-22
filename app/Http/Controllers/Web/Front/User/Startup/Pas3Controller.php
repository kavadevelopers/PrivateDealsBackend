<?php

namespace App\Http\Controllers\Web\Front\User\Startup;

use App\Enums\DocumentTypeEnum;
use App\Enums\Utills\StatusEnum;
use App\Helpers\FileUpDownHelper;
use App\Helpers\UtillsHelper;
use App\Models\DocumentsModel;
use App\Models\PrimaryTransactionMgt14Model;
use App\Models\PrimaryTransactionModel;
use App\Models\PrimaryTransactionPas3Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Http\Controllers\Controller;

class Pas3Controller extends Controller
{
    function list(): View
    {
        setPageTitle('PAS-3');
        $data['list'] = PrimaryTransactionPas3Model::where('startup_id', Auth::guard('startup')->user()->id)->orderby('id', 'desc');
        $data['last'] = PrimaryTransactionPas3Model::where('startup_id', Auth::guard('startup')->user()->id)->orderby('id', 'desc')->first();
        $data['transactions'] = PrimaryTransactionModel::where('startup_id', Auth::guard('startup')->user()->id)->where('status', '7')->count();
        return view('front.startup.pas3.list', $data);
    }

    function showForm(): View|RedirectResponse
    {
        setPageTitle('PAS-3');
        $data['last'] = PrimaryTransactionMgt14Model::where('startup_id', Auth::guard('startup')->user()->id)->where('status', StatusEnum::approved->value)->orderby('id', 'desc')->first();
        $data['transactions'] = PrimaryTransactionModel::where('mgt14_id', '!=', NULL)->where('startup_id', Auth::guard('startup')->user()->id)->where('status', '7')->get();
        if ($data['last']) {
            return view('front.startup.pas3.create', $data);
        } else {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    function save(Request $request): RedirectResponse
    {
        $validation = Validator::make($request->all(), [
            'srn_no'            => 'required|numeric',
            'pas3_zip_file'     => 'required|file|mimes:zip|max:' . UtillsHelper::maxFileDocumentSizeInKB(),
            'transactions'          => 'required|array',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withInput()->with('error', $validation->errors()->first());
        }
        $transactions = PrimaryTransactionModel::wherein('id', $request->transactions)->get();
        $investors = [];
        $primary_transactions = [];
        foreach ($transactions as $key => $value) {
            array_push($investors, $value->investor_id);
            array_push($primary_transactions, $value->id);
        }
        $meta = [
            'investor'              => $investors,
            'primary_transactions'  => $primary_transactions,
            'startup'               => [Auth::guard('startup')->user()->id]
        ];

        $pas3 = new PrimaryTransactionPas3Model();
        $pas3->startup_id = Auth::guard('startup')->user()->id;
        $pas3->srn_no = $request->srn_no;
        $pas3->mgt14_id  = $request->mgt14;
        $pas3->status = StatusEnum::pending;
        $pas3->meta = $meta;
        if ($request->hasFile('pas3_zip_file')) {
            $file = FileUpDownHelper::startup_pas3_upload($request->file('pas3_zip_file'));
            if ($file) {
                $meta['name']   = Auth::guard('startup')->user()->brand_name . ' PAS3';
                $meta['sname']   = 'PAS3 - Zip';
                $document = new DocumentsModel();
                $document->api_id = NULL;
                $document->path = $file;
                $document->signed_path = $file;
                $document->status = 0;
                $document->type = DocumentTypeEnum::pas;
                $document->meta = $meta;
                $document->save();
                if ($document) {
                    $pas3->zip  = $document->id;
                }
            }
        }
        $pas3->save();

        return redirect()->route('front.raise.pas3.list')->with('success', 'PAS-3 Uploaded');
    }
}
