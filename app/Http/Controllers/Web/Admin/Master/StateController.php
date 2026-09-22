<?php

namespace App\Http\Controllers\Web\Admin\Master;

use App\Helpers\AdminHelper;
use App\Http\Controllers\Controller;
use App\Models\MasterCountryModel;
use App\Models\MasterStateModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class StateController extends Controller
{
    public function index(): View
    {
        setPageTitle('State');
        $data['stateList'] = MasterStateModel::where('is_deleted', '0')->with('MasterCountry')->orderby('id', 'desc')->get();
        $data['country'] = MasterCountryModel::where('is_deleted', '0')->orderby('id', 'desc')->get();
        addVendor('datatables');
        return view('admin.pages.master.state')->with($data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $state = new MasterStateModel();
        $validation = Validator::make($request->all(), [
            'name' => [
                'required',
                'max:255',
                'string',
                Rule::unique($state->getTable())->where(function ($query) use ($request) {
                    return $query->where('is_deleted', '0');
                }),
            ],
            'country_id' => 'required'
        ]);
        if ($validation->fails()) {
            return redirect()->route('admin.master.state.index')->withInput()
                ->with('error', $validation->errors()->first());
        }


        $state->name = $request->name;
        $state->country_id = $request->country_id;
        $state->save();

        AdminHelper::logPut('Created state master', MasterStateModel::class, $state->id);
        return redirect()->route('admin.master.state.index')
            ->with('success', 'State created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $item = MasterStateModel::where('is_deleted', '0')->find($id);
        if ($item) {
            setPageTitle('Masters State');
            $data['item'] = $item;
            $data['stateList'] = MasterStateModel::where('is_deleted', '0')->with('MasterCountry')->orderby('id', 'desc')->get();
            $data['country'] = MasterCountryModel::where('is_deleted', '0')->orderby('id', 'desc')->get();
            addVendor('datatables');
            return view('admin.pages.master.state')->with($data);
        }

        return redirect()->route('admin.master.state.index')
            ->with('error', 'Item not found');
    }

    public function update(Request $request, string $id)
    {
        $item = MasterStateModel::where('is_deleted', '0')->find($id);
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
                'country_id' => [
                    'required',
                ],
            ]);
            if ($validation->fails()) {
                return redirect()->back()->withInput()
                    ->with('error', $validation->errors()->first());
            }

            $item->name = $request->name;
            $item->country_id = $request->country_id;
            $item->update();

            AdminHelper::logPut('Updated state master', MasterStateModel::class, $item->id);

            return redirect()->route('admin.master.state.index')
                ->with('success', 'State Updated Successfully.');
        }

        return redirect()->route('admin.master.state.index')
            ->with('error', 'Item Not Found');
    }

    public function destroy(string $id)
    {
        $item = MasterStateModel::where('is_deleted', '0')->find($id);

        if ($item) {
            $item->is_deleted = '1';
            $item->update();

            AdminHelper::logPut('Deleted state master', MasterStateModel::class, $item->id);

            return redirect()->route('admin.master.state.index')
                ->with('success', 'State deleted successfully.');
        }

        return redirect()->route('admin.master.state.index')
            ->with('error', 'Item not found');
    }
}
