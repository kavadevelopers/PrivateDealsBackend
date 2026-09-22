<?php

namespace App\Http\Controllers\Web\Admin\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterInstrumentTypeModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class InstrumentTypeController extends Controller
{
    public function index(): View
    {
        setPageTitle('Instrument Type');
        $data['instrumenttypeList'] = MasterInstrumentTypeModel::where('is_deleted', '0')->orderby('id', 'desc')->get();
        addVendor('datatables');
        return view('admin.pages.master.instrument_type')->with($data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request): RedirectResponse
    {
        $instrumenttype = new MasterInstrumentTypeModel();
        $validation = Validator::make($request->all(), [
            'name' => [
                'required',
                'max:255',
                'string',
                Rule::unique($instrumenttype->getTable())->where(function ($query) use ($request) {
                    return $query->where('is_deleted', '0');
                }),
            ],
        ]);
        if ($validation->fails()) {
            return redirect()->route('admin.master.instrument-type.index')->withInput()
                ->with('error', $validation->errors()->first());
        }

        $instrumenttype->name = $request->name;
        $instrumenttype->save();

        return redirect()->route('admin.master.instrument-type.index')
            ->with('success', 'Instrument Type created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id): View
    {
        $item = MasterInstrumentTypeModel::where('is_deleted', '0')->find($id);
        if ($item) {
            setPageTitle('Instrument Type');
            $data['item'] = $item;
            $data['instrumenttypeList'] = MasterInstrumentTypeModel::where('is_deleted', '0')->orderby('id', 'desc')->get();
            addVendor('datatables');
            return view('admin.pages.master.instrument_type')->with($data);
        }

        return redirect()->route('admin.master.instrument-type.index')
            ->with('error', 'Item not found');
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $item = MasterInstrumentTypeModel::where('is_deleted', '0')->find($id);
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

            return redirect()->route('admin.master.instrument-type.index')
                ->with('success', 'Instrument Type Updated Successfully.');
        }

        return redirect()->route('admin.master.instrument-type.index')
            ->with('error', 'Item Not Found');
    }

    public function destroy(string $id): RedirectResponse
    {
        $item = MasterInstrumentTypeModel::where('is_deleted', '0')->find($id);

        if ($item) {
            $item->is_deleted = '1';
            $item->update();

            return redirect()->route('admin.master.instrument-type.index')
                ->with('success', 'Instrument Type deleted successfully.');
        }

        return redirect()->route('admin.master.instrument-type.index')
            ->with('error', 'Item not found');
    }
}
