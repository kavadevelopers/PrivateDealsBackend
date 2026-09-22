<?php

namespace App\Http\Controllers\Web\Admin;

use App\Helpers\AdminHelper;
use App\Helpers\CommonHelper;
use App\Helpers\FileUpDownHelper;
use App\Helpers\UtillsHelper;
use App\Http\Controllers\Controller;
use App\Models\SellerMasterModel;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SellerMasterController extends Controller
{
    use FileUploadTrait;

    function create(): View
    {
        setPageTitle('Create Seller');
        return view('admin.pages.seller.create');
    }

    function save(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'cin' => 'required|string|max:21',
            'pan' => 'required|string|max:10',
            'company_name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:' . CommonHelper::appSettings('file_image_extensions_allowed') . '|max:' . UtillsHelper::maxFileImageSizeInKB(),
            'address' => 'required',
            'dp_id' => 'required|string|max:15',
            'client_id' => 'required|string|max:15',
            'bank_name' => 'required',
            'account_number' => 'required|string|digits_between:9,18',
            'ifsc' => 'required|string|size:11',
            'branch' => 'required|string|max:255',
            'mobile_country_code' => 'nullable|string|max:5',
            'mobile_number' => [
                'nullable',
                'numeric',
                'digits:10',
                Rule::unique('seller_master', 'mobile_number')->where(fn ($q) => $q->where('is_deleted', 0)),
            ],
            'email' => 'nullable|email|max:255',
            'password' => 'nullable|string|min:6',
            'is_blocked' => 'nullable|boolean',
            'is_primary_access' => 'nullable|boolean',
            'is_secondary_access' => 'nullable|boolean',
            'is_preipo_access' => 'nullable|boolean',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withInput()->withErrors($validation)
                ->with('error', 'Please check form errors.');
        }

        $seller = new SellerMasterModel();
        $seller->cin = $request->cin;
        $seller->pan = $request->pan;
        $seller->company_name = $request->company_name;
        $seller->address = $request->address;
        $seller->dp_id = $request->dp_id;
        $seller->client_id = $request->client_id;
        $seller->bank_name = $request->bank_name;
        $seller->account_number = $request->account_number;
        $seller->ifsc = $request->ifsc;
        $seller->branch = $request->branch;
        $seller->mobile_country_code = $request->mobile_country_code ?: '91';
        $seller->mobile_number = $request->mobile_number;
        $seller->email = $request->email;
        if ($request->hasFile('logo')) {
            $seller->logo = FileUpDownHelper::seller_logo_upload($request->file('logo'));
        }
        if ($request->password) {
            $seller->password = Hash::make($request->password);
            $seller->ask_password_change = '1';
        }
        $seller->is_blocked = $request->boolean('is_blocked') ? '1' : '0';
        $seller->is_primary_access = $request->boolean('is_primary_access') ? 1 : 0;
        $seller->is_secondary_access = $request->boolean('is_secondary_access') ? 1 : 0;
        $seller->is_preipo_access = $request->boolean('is_preipo_access') ? 1 : 0;
        $seller->created_by = Auth::guard('admin')->user()->id;
        $seller->updated_by = Auth::guard('admin')->user()->id;
        $seller->save();
        AdminHelper::logPut('Seller Created', SellerMasterModel::class, $seller->id);
        return redirect()->route('admin.preiposeller.list')->with('success', 'Seller Created');
    }

    function list(): View
    {
        setPageTitle('Sellers');
        $data['list']   = SellerMasterModel::where('is_deleted', '0')->get();
        return view('admin.pages.seller.list', $data);
    }

    function edit(string $uuid): RedirectResponse|View
    {
        $item = SellerMasterModel::where('uuid', $uuid)->where('is_deleted', 0)->first();
        if ($item) {
            setPageTitle('Edit Seller');
            $data['item']   = $item;
            return view('admin.pages.seller.edit', $data);
        }
        return redirect()->back()->with('error', 'Seller not found');
    }

    function update(Request $request, string $uuid)
    {
        $seller = SellerMasterModel::where('uuid', $uuid)->where('is_deleted', 0)->first();
        if (!$seller) {
            return redirect()->route('admin.preiposeller.list')->with('error', 'Seller Not Updated');
        }

        $validation = Validator::make($request->all(), [
            'cin' => 'required|string|max:21',
            'pan' => 'required|string|max:10',
            'company_name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:' . CommonHelper::appSettings('file_image_extensions_allowed') . '|max:' . UtillsHelper::maxFileImageSizeInKB(),
            'address' => 'required',
            'dp_id' => 'required|string|max:15',
            'client_id' => 'required|string|max:15',
            'bank_name' => 'required',
            'account_number' => 'required|string|digits_between:9,18',
            'ifsc' => 'required|string|size:11',
            'branch' => 'required|string|max:255',
            'mobile_country_code' => 'nullable|string|max:5',
            'mobile_number' => [
                'nullable',
                'numeric',
                'digits:10',
                Rule::unique('seller_master', 'mobile_number')
                    ->ignore($seller->id)
                    ->where(fn ($q) => $q->where('is_deleted', 0)),
            ],
            'email' => 'nullable|email|max:255',
            'password' => 'nullable|string|min:6',
            'is_blocked' => 'nullable|boolean',
            'is_primary_access' => 'nullable|boolean',
            'is_secondary_access' => 'nullable|boolean',
            'is_preipo_access' => 'nullable|boolean',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withInput()->withErrors($validation)
                ->with('error', 'Please check form errors.');
        }

        $seller->cin = $request->cin;
        $seller->pan = $request->pan;
        $seller->company_name = $request->company_name;
        $seller->address = $request->address;
        $seller->dp_id = $request->dp_id;
        $seller->client_id = $request->client_id;
        $seller->bank_name = $request->bank_name;
        $seller->account_number = $request->account_number;
        $seller->ifsc = $request->ifsc;
        $seller->branch = $request->branch;
        $seller->mobile_country_code = $request->mobile_country_code ?: '91';
        $seller->mobile_number = $request->mobile_number;
        $seller->email = $request->email;
        if ($request->hasFile('logo')) {
            if ($seller->logo && $seller->logo != NULL) {
                $this->deleteFile($seller->logo);
            }
            $seller->logo = FileUpDownHelper::seller_logo_upload($request->file('logo'));
        }
        if ($request->password) {
            $seller->password = Hash::make($request->password);
            $seller->ask_password_change = '1';
        }
        $seller->is_blocked = $request->boolean('is_blocked') ? '1' : '0';
        $seller->is_primary_access = $request->boolean('is_primary_access') ? 1 : 0;
        $seller->is_secondary_access = $request->boolean('is_secondary_access') ? 1 : 0;
        $seller->is_preipo_access = $request->boolean('is_preipo_access') ? 1 : 0;
        $seller->updated_by = Auth::guard('admin')->user()->id;
        $seller->update();
        AdminHelper::logPut('Seller Updated', SellerMasterModel::class, $seller->id);
        return redirect()->route('admin.preiposeller.list')->with('success', 'Seller Updated');
    }

    function delete(string $uuid): RedirectResponse
    {
        $item = SellerMasterModel::where('uuid', $uuid)->first();
        if ($item) {
            $item->is_deleted = '1';
            $item->save();
            return redirect()->back()->with('success', 'Seller Deleted');
        }
        return redirect()->back()->with('error', 'Seller not found');
    }
}
