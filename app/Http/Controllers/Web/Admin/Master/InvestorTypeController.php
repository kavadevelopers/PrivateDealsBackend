<?php

namespace App\Http\Controllers\Web\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterInvestorTypeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class InvestorTypeController extends Controller
{
    public function index(): View
    {
        setPageTitle('Investor Type');
        $data['investortypeList'] = MasterInvestorTypeModel::where('is_deleted', '0')->orderby('id', 'desc')->get();
        addVendor('datatables');
        return view('admin.pages.master.investor_type')->with($data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $investortype = new MasterInvestorTypeModel();
        $validation = Validator::make($request->all(), [
            'name' => [
                'required',
                'max:255',
                'string',
                Rule::unique($investortype->getTable())->where(function ($query) use ($request) {
                    return $query->where('is_deleted', '0');
                }),
            ],
        ]);
        if ($validation->fails()) {
            return redirect()->route('admin.master.investor-type.index')->withInput()
                ->with('error', $validation->errors()->first());
        }

        $investortype->name = $request->name;
        $investortype->save();

        return redirect()->route('admin.master.investor-type.index')
            ->with('success', 'Investor Type created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $item = MasterInvestorTypeModel::where('is_deleted', '0')->find($id);
        if ($item) {
            setPageTitle('Masters Investor Type');
            $data['item'] = $item;
            $data['investortypeList'] = MasterInvestorTypeModel::where('is_deleted', '0')->orderby('id', 'desc')->get();
            addVendor('datatables');
            return view('admin.pages.master.investor_type')->with($data);
        }

        return redirect()->route('admin.master.investor-type.index')
            ->with('error', 'Item not found');
    }

    public function update(Request $request, string $id)
    {
        $item = MasterInvestorTypeModel::where('is_deleted', '0')->find($id);
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

            return redirect()->route('admin.master.investor-type.index')
                ->with('success', 'Investor Type Updated Successfully.');
        }

        return redirect()->route('admin.master.investor-type.index')
            ->with('error', 'Item Not Found');
    }

    public function destroy(string $id)
    {
        $item = MasterInvestorTypeModel::where('is_deleted', '0')->find($id);

        if ($item) {
            $item->is_deleted = '1';
            $item->update();

            return redirect()->route('admin.master.investor-type.index')
                ->with('success', 'Investor Type deleted successfully.');
        }

        return redirect()->route('admin.master.investor-type.index')
            ->with('error', 'Item not found');
    }
}
