<?php

namespace App\Http\Controllers\Web\Front\User\Startup;

use App\Http\Controllers\Controller;
use App\Enums\DocumentTypeEnum;
use App\Helpers\FileUpDownHelper;
use App\Helpers\UtillsHelper;
use App\Models\DocumentsModel;
use App\Models\PrimaryTransactionMgt14Model;
use App\Models\PrimaryTransactionModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class StartupMgt14Controller extends Controller
{
    function list(): View
    {
        setPageTitle('MGT-14');
        $data['list'] = PrimaryTransactionMgt14Model::where('startup_id', Auth::guard('startup')->user()->id)->orderby('id', 'desc');
        $data['last'] = PrimaryTransactionMgt14Model::where('startup_id', Auth::guard('startup')->user()->id)->orderby('id', 'desc')->first();
        return view('front.startup.mgt14.list', $data);
    }

    function showForm(): View
    {
        setPageTitle('Upload MGT14');
        $data['transactions'] = PrimaryTransactionModel::where('mgt14_id', NULL)->where('startup_id', Auth::guard('startup')->user()->id)->get();
        return view('front.startup.mgt14.create', $data);
    }

    function save(Request $request): RedirectResponse
    {
        $validation = Validator::make($request->all(), [
            'srn_no'                        => 'required|numeric',
            'mgt14_zip_file'                => 'required|file|mimes:zip|max:' . UtillsHelper::maxFileDocumentSizeInKB(),
            'mgt14_challan_file'            => 'required|file|mimes:pdf|max:' . UtillsHelper::maxFileDocumentSizeInKB(),
            'transactions'                  => 'required|array'
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


        $mgt14 = new PrimaryTransactionMgt14Model();
        $mgt14->startup_id = Auth::guard('startup')->user()->id;
        $mgt14->srn_no  = $request->srn_no;
        $mgt14->meta = $meta;
        if ($request->hasFile('mgt14_challan_file')) {
            $file = FileUpDownHelper::startup_mgt14_upload($request->file('mgt14_challan_file'));
            if ($file) {
                $meta['name']   = Auth::guard('startup')->user()->brand_name . ' MGT14 - Challan';
                $meta['sname']   = 'MGT14 - Challan';
                $document = new DocumentsModel();
                $document->api_id = NULL;
                $document->path = $file;
                $document->signed_path = $file;
                $document->status = 0;
                $document->type = DocumentTypeEnum::mgtchallan;
                $document->meta = $meta;
                $document->save();
                if ($document) {
                    $mgt14->challan  = $document->id;
                }
            }
        }

        if ($request->hasFile('mgt14_zip_file')) {
            $file = FileUpDownHelper::startup_mgt14_upload($request->file('mgt14_zip_file'));
            if ($file) {
                $meta['name']   = Auth::guard('startup')->user()->brand_name . ' MGT14 - Zip';
                $meta['sname']   = 'MGT14 - Zip';
                $document = new DocumentsModel();
                $document->api_id = NULL;
                $document->path = $file;
                $document->signed_path = $file;
                $document->status = 0;
                $document->type = DocumentTypeEnum::mgtzip;
                $document->meta = $meta;
                $document->save();
                if ($document) {
                    $mgt14->zip  = $document->id;
                }
            }
        }

        $mgt14->save();

        return redirect()->route('front.raise.mgt14.list')->with('success', 'MGT14 Uploaded');
    }
}
