<?php

namespace App\Http\Controllers\Web\Admin\Master;

use App\Helpers\AdminHelper;
use App\Http\Controllers\Controller;
use App\Models\MasterBankModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BankController extends Controller
{
    public function index(): View
    {
        setPageTitle('Bank');
        $data['bankList'] = MasterBankModel::where('is_deleted', '0')->orderby('id', 'desc')->get();
        addVendor('datatables');
        return view('admin.pages.master.bank')->with($data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request): RedirectResponse
    {
        $bank = new MasterBankModel();
        $validation = Validator::make($request->all(), [
            'name' => [
                'required',
                'max:255',
                'string',
                Rule::unique($bank->getTable())->where(function ($query) use ($request) {
                    return $query->where('is_deleted', '0');
                }),
            ],
        ]);
        if ($validation->fails()) {
            return redirect()->route('admin.master.bank.index')->withInput()
                ->with('error', $validation->errors()->first());
        }

        $bank->name = $request->name;
        $bank->save();

        AdminHelper::logPut('Created master bank', MasterBankModel::class, $bank->id);

        return redirect()->route('admin.master.bank.index')
            ->with('success', 'Bank created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id): View
    {
        $item = MasterBankModel::where('is_deleted', '0')->find($id);
        if ($item) {
            setPageTitle('Masters bank');
            $data['item'] = $item;
            $data['bankList'] = MasterBankModel::where('is_deleted', '0')->orderby('id', 'desc')->get();
            addVendor('datatables');
            return view('admin.pages.master.bank')->with($data);
        }

        return redirect()->route('admin.master.bank.index')
            ->with('error', 'Item not found');
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $item = MasterBankModel::where('is_deleted', '0')->find($id);
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

            AdminHelper::logPut('Updated master bank', MasterBankModel::class, $item->id);

            return redirect()->route('admin.master.bank.index')
                ->with('success', 'Bank Updated Successfully.');
        }

        return redirect()->route('admin.master.bank.index')
            ->with('error', 'Item Not Found');
    }

    public function destroy(string $id): RedirectResponse
    {
        $item = MasterBankModel::where('is_deleted', '0')->find($id);

        if ($item) {
            $item->is_deleted = '1';
            $item->update();

            AdminHelper::logPut('Deleted master bank', MasterBankModel::class, $item->id);

            return redirect()->route('admin.master.bank.index')
                ->with('success', 'Bank deleted successfully.');
        }

        return redirect()->route('admin.master.bank.index')
            ->with('error', 'Item not found');
    }
}
