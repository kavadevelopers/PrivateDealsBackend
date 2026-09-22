<?php

namespace App\Http\Controllers\Web\Admin\Master;

use App\Helpers\AdminHelper;
use App\Http\Controllers\Controller;
use App\Models\MasterCountryModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CountryController extends Controller
{
    public function index(): View
    {
        setPageTitle('Country');
        $data['countryList'] = MasterCountryModel::where('is_deleted', '0')->orderby('id', 'desc')->get();
        addVendor('datatables');
        return view('admin.pages.master.country')->with($data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request): RedirectResponse
    {
        $country = new MasterCountryModel();
        $validation = Validator::make($request->all(), [
            'name' => [
                'required',
                'max:255',
                'string',
                Rule::unique($country->getTable())->where(function ($query) use ($request) {
                    return $query->where('is_deleted', '0');
                }),
            ],
        ]);
        if ($validation->fails()) {
            return redirect()->route('admin.master.country.index')->withInput()
                ->with('error', $validation->errors()->first());
        }

        $country->name = $request->name;
        $country->save();

        AdminHelper::logPut('Created master country', MasterCountryModel::class, $country->id);

        return redirect()->route('admin.master.country.index')
            ->with('success', 'Country created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id): View|RedirectResponse
    {
        $item = MasterCountryModel::where('is_deleted', '0')->find($id);
        if ($item) {
            setPageTitle('Masters Country');
            $data['item'] = $item;
            $data['countryList'] = MasterCountryModel::where('is_deleted', '0')->orderby('id', 'desc')->get();
            addVendor('datatables');
            return view('admin.pages.master.country')->with($data);
        }

        return redirect()->route('admin.master.country.index')
            ->with('error', 'Item not found');
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $item = MasterCountryModel::where('is_deleted', '0')->find($id);
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

            AdminHelper::logPut('Updated master country', MasterCountryModel::class, $item->id);

            return redirect()->route('admin.master.country.index')
                ->with('success', 'Country Updated Successfully.');
        }

        return redirect()->route('admin.master.country.index')
            ->with('error', 'Item Not Found');
    }

    public function destroy(string $id): RedirectResponse
    {
        $item = MasterCountryModel::where('is_deleted', '0')->find($id);

        if ($item) {
            $item->is_deleted = '1';
            $item->update();

            AdminHelper::logPut('Deleted master country', MasterCountryModel::class, $item->id);

            return redirect()->route('admin.master.country.index')
                ->with('success', 'Country deleted successfully.');
        }

        return redirect()->route('admin.master.Country.index')
            ->with('error', 'Item not found');
    }
}
