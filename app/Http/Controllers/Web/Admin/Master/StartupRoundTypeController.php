<?php

namespace App\Http\Controllers\Web\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterStartupRoundTypeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StartupRoundTypeController extends Controller
{
    public function index()
    {
        setPageTitle('Startup Round Type');
        $data['roundtypeList'] = MasterStartupRoundTypeModel::where('is_deleted', '0')->orderby('id', 'desc')->get();
        addVendor('datatables');
        return view('admin.pages.master.startup_round_type')->with($data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $roundtype = new MasterStartupRoundTypeModel();
        $validation = Validator::make($request->all(), [
            'name' => [
                'required',
                'max:255',
                'string',
                Rule::unique($roundtype->getTable())->where(function ($query) use ($request) {
                    return $query->where('is_deleted', '0');
                }),
            ],
        ]);
        if ($validation->fails()) {
            return redirect()->route('admin.master.startup-round-type.index')->withInput()
                ->with('error', $validation->errors()->first());
        }

        $roundtype->name = $request->name;
        $roundtype->save();

        return redirect()->route('admin.master.startup-round-type.index')
            ->with('success', 'Startup Round Type created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $item = MasterStartupRoundTypeModel::where('is_deleted', '0')->find($id);
        if ($item) {
            setPageTitle('Masters Startup Round Type');
            $data['item'] = $item;
            $data['roundtypeList'] = MasterStartupRoundTypeModel::where('is_deleted', '0')->orderby('id', 'desc')->get();
            addVendor('datatables');
            return view('admin.pages.master.startup_round_type')->with($data);
        }

        return redirect()->route('admin.master.startup-round-type.index')
            ->with('error', 'Item not found');
    }

    public function update(Request $request, string $id)
    {
        $item = MasterStartupRoundTypeModel::where('is_deleted', '0')->find($id);
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

            return redirect()->route('admin.master.startup-round-type.index')
                ->with('success', 'Startup Round Type Updated Successfully.');
        }

        return redirect()->route('admin.master.startup-round-type.index')
            ->with('error', 'Item Not Found');
    }

    public function destroy(string $id)
    {
        $item = MasterStartupRoundTypeModel::where('is_deleted', '0')->find($id);

        if ($item) {
            $item->is_deleted = '1';
            $item->update();

            return redirect()->route('admin.master.startup-round-type.index')
                ->with('success', 'Startup Round Type deleted successfully.');
        }

        return redirect()->route('admin.master.startup-round-type.index')
            ->with('error', 'Item not found');
    }
}
