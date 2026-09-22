<?php

namespace App\Http\Controllers\Web\Admin\Master;

use App\Helpers\AdminHelper;
use App\Http\Controllers\Controller;
use App\Models\MasterCityModel;
use App\Models\MasterCountryModel;
use App\Models\MasterStateModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CityController extends Controller
{
    public function index(): View
    {
        setPageTitle('City');
        $data['state'] = MasterStateModel::where('is_deleted', '0')->orderby('id', 'desc')->get();
        $data['country'] = MasterCountryModel::where('is_deleted', '0')->orderby('id', 'desc')->get();
        $data['citylist'] = MasterCityModel::where('is_deleted', '0')->with('MasterState', 'MasterCountry')->orderby('id', 'desc')->get();
        addVendor('datatables');
        return view('admin.pages.master.city')->with($data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request): RedirectResponse
    {
        $city = new MasterCityModel();
        $validation = Validator::make($request->all(), [
            'name' => [
                'required',
                'max:255',
                'string',
                Rule::unique($city->getTable())->where(function ($query) use ($request) {
                    return $query->where('is_deleted', '0')->where('state_id', $request->state_id);
                }),
            ],
            'state_id'  =>  'required'
        ]);
        if ($validation->fails()) {
            return redirect()->route('admin.master.city.index')->withInput()
                ->with('error', $validation->errors()->first());
        }

        $city->name = $request->name;
        $city->state_id = $request->state_id;
        $state = MasterStateModel::find($request->state_id);
        if ($state) {
            $city->country_id = $state->country_id;
        }
        $city->save();

        AdminHelper::logPut('Created master city', MasterCountryModel::class, $city->id);

        return redirect()->route('admin.master.city.index')
            ->with('success', 'City created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id): View|RedirectResponse
    {
        $item = MasterCityModel::where('is_deleted', '0')->find($id);
        if ($item) {
            setPageTitle('Masters City');
            $data['item'] = $item;
            $data['state'] = MasterStateModel::where('is_deleted', '0')->orderby('id', 'desc')->get();
            $data['country'] = MasterCountryModel::where('is_deleted', '0')->orderby('id', 'desc')->get();
            $data['citylist'] = MasterCityModel::where('is_deleted', '0')->with('MasterState', 'MasterCountry')->orderby('id', 'desc')->get();
            addVendor('datatables');
            return view('admin.pages.master.city')->with($data);
        }

        return redirect()->route('admin.master.city.index')
            ->with('error', 'Item not found');
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $item = MasterCityModel::where('is_deleted', '0')->find($id);
        if ($item) {
            $validation = Validator::make($request->all(), [
                'name' => [
                    'required',
                    'max:255',
                    'string',
                    Rule::unique($item->getTable())->where(function ($query) use ($request, $item) {
                        return $query->where('is_deleted', '0')->where('state_id', $request->state_id)->where('id', '!=', $item->id);
                    }),
                ],
                // 'country_id' => 'required',
                'state_id'  =>  'required'
            ]);
            if ($validation->fails()) {
                return redirect()->back()->withInput()
                    ->with('error', $validation->errors()->first());
            }

            $item->name = $request->name;
            $item->state_id = $request->state_id;
            $state = MasterStateModel::find($request->state_id);
            if ($state) {
                $item->country_id = $state->country_id;
            }
            $item->update();

            AdminHelper::logPut('Updated master city', MasterCountryModel::class, $item->id);

            return redirect()->route('admin.master.city.index')
                ->with('success', 'City Updated Successfully.');
        }

        return redirect()->route('admin.master.city.index')
            ->with('error', 'Item Not Found');
    }

    public function destroy(string $id): RedirectResponse
    {
        $item = MasterCityModel::where('is_deleted', '0')->find($id);

        if ($item) {
            $item->is_deleted = '1';
            $item->update();

            AdminHelper::logPut('Deleted master city', MasterCountryModel::class, $item->id);

            return redirect()->route('admin.master.city.index')
                ->with('success', 'City deleted successfully.');
        }

        return redirect()->route('admin.master.city.index')
            ->with('error', 'Item not found');
    }
}
