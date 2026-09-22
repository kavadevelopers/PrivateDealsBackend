<?php

namespace App\Http\Controllers\Web\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterBankAccountTypeModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BankAccountTypeController extends Controller
{
    public function index(): View
    {
        setPageTitle('Bank Account Type');
        $data['bankaccountList'] = MasterBankAccountTypeModel::where('is_deleted', '0')->orderby('id', 'desc')->get();
        addVendor('datatables');
        return view('admin.pages.master.bank_account_type')->with($data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request): RedirectResponse
    {
        $bankaccount = new MasterBankAccountTypeModel();
        $validation = Validator::make($request->all(), [
            'name' => [
                'required',
                'max:255',
                'string',
                Rule::unique($bankaccount->getTable())->where(function ($query) use ($request) {
                    return $query->where('is_deleted', '0');
                }),
            ],
        ]);
        if ($validation->fails()) {
            return redirect()->route('admin.master.bank-account-type.index')->withInput()
                ->with('error', $validation->errors()->first());
        }

        $bankaccount->name = $request->name;
        $bankaccount->save();

        return redirect()->route('admin.master.bank-account-type.index')
            ->with('success', 'Bank Account Type created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id): View
    {
        $item = MasterBankAccountTypeModel::where('is_deleted', '0')->find($id);
        if ($item) {
            setPageTitle('Masters Bank Account Type');
            $data['item'] = $item;
            $data['bankaccountList'] = MasterBankAccountTypeModel::where('is_deleted', '0')->orderby('id', 'desc')->get();
            addVendor('datatables');
            return view('admin.pages.master.bank_account_type')->with($data);
        }
        return redirect()->route('admin.master.bank-account-type.index')
            ->with('error', 'Item not found');
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $item = MasterBankAccountTypeModel::where('is_deleted', '0')->find($id);
        if ($item) {
            $validation = Validator::make($request->all(), [
                'name' => [
                    'required',
                    'max:255',
                    'string',
                    Rule::unique($item->getTable())->where(function ($query) use ($item) {
                        return $query->where('is_deleted', '0')->where('id', '!=', $item->id);
                    }),
                ],
            ]);
            if ($validation->fails()) {
                return redirect()->back()->withInput()
                    ->with('error', $validation->errors()->first());
            }

            $item->name = $request->name;
            $item->update();

            return redirect()->route('admin.master.bank-account-type.index')
                ->with('success', 'Bank Account Type Updated Successfully.');
        }

        return redirect()->route('admin.master.bank-account-type.index')
            ->with('error', 'Item Not Found');
    }

    public function destroy(string $id): RedirectResponse
    {
        $item = MasterBankAccountTypeModel::where('is_deleted', '0')->find($id);

        if ($item) {
            $item->is_deleted = '1';
            $item->update();

            return redirect()->route('admin.master.bank-account-type.index')
                ->with('success', 'Bank Account Type deleted successfully.');
        }

        return redirect()->route('admin.master.bank-account-type.index')
            ->with('error', 'Item not found');
    }
}
