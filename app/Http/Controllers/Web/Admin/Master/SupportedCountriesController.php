<?php

namespace App\Http\Controllers\Web\Admin\Master;

use App\Helpers\AdminHelper;
use App\Helpers\CommonHelper;
use App\Helpers\FileUpDownHelper;
use App\Helpers\UtillsHelper;
use App\Http\Controllers\Controller;
use App\Models\MasterSupportedCountriesModel;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SupportedCountriesController extends Controller
{
    use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        setPageTitle('Masters Supported Countries');
        $data['list'] = MasterSupportedCountriesModel::where('is_deleted', '0')->orderByRaw("CASE WHEN name = 'India' THEN 0 ELSE 1 END")->orderby('name', 'asc')->get();
        addVendors(['datatables', 'lazy-image']);
        return view('admin.pages.master.supported_countries')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $supportedCountries = new MasterSupportedCountriesModel();
        $validation = Validator::make($request->all(), [
            'code' => [
                'required',
                Rule::unique($supportedCountries->getTable())->where(function ($query) {
                    return $query->where('is_deleted', '0');
                }),
            ],
            'name' => [
                'required',
                'max:255',
                'string',
                Rule::unique($supportedCountries->getTable())->where(function ($query) use ($request) {
                    return $query->where('is_deleted', '0');
                }),
            ],
            'flag' => 'nullable|image|mimes:' . CommonHelper::appSettings('file_image_extensions_allowed') . '|max:' . UtillsHelper::maxFileImageSizeInKB(),
        ]);
        if ($validation->fails()) {
            return redirect()->route('admin.master.supported-countries.index')->withInput()
                ->with('error', $validation->errors()->first());
        }

        $supportedCountries->code = $request->code;
        $supportedCountries->name = $request->name;
        if ($request->hasFile('flag')) {
            $supportedCountries->flag = FileUpDownHelper::master_supported_countries_flag_upload($request->file('flag'));
        }
        $supportedCountries->save();

        AdminHelper::logPut('Created supportedCountries master', MasterSupportedCountriesModel::class, $supportedCountries->id);

        return redirect()->route('admin.master.supported-countries.index')
            ->with('success', 'supportedCountries created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = MasterSupportedCountriesModel::where('is_deleted', '0')->find($id);
        if ($item) {
            setPageTitle('Masters Supported Countries');
            $data['item'] = $item;
            $data['list'] = MasterSupportedCountriesModel::where('is_deleted', '0')->orderby('name', 'asc')->get();
            addVendor('datatables');
            return view('admin.pages.master.supported_countries')->with($data);
        }

        return redirect()->route('admin.master.supported-countries.index')
            ->with('error', 'Item not found');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = MasterSupportedCountriesModel::where('is_deleted', '0')->find($id);
        if ($item) {
            $validation = Validator::make($request->all(), [
                'code' => 'required',
                'name' => [
                    'required',
                    'max:255',
                    'string',
                    Rule::unique($item->getTable())->where(function ($query) use ($item) {
                        return $query->where('is_deleted', '0')->where('id', '!=', $item->id);
                    }),
                ],
                'flag' => 'nullable|image|mimes:' . CommonHelper::appSettings('file_image_extensions_allowed') . '|max:' . UtillsHelper::maxFileImageSizeInKB(),
            ]);
            if ($validation->fails()) {
                return redirect()->back()->withInput()
                    ->with('error', $validation->errors()->first());
            }

            $item->code = $request->code;
            $item->name = $request->name;
            if ($request->hasFile('flag')) {
                $file = FileUpDownHelper::master_supported_countries_flag_upload($request->file('flag'));
                if ($file) {
                    $this->deleteFile($item->flag);
                    $item->flag = $file;
                }
            }
            $item->update();

            AdminHelper::logPut('Updated supportedCountries master', MasterSupportedCountriesModel::class, $item->id);

            return redirect()->route('admin.master.supported-countries.index')
                ->with('success', 'supportedCountries updated successfully.');
        }

        return redirect()->route('admin.master.supported-countries.index')
            ->with('error', 'Item not found');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = MasterSupportedCountriesModel::where('is_deleted', '0')->find($id);

        if ($item) {
            $item->is_deleted = '1';
            $item->update();
            $this->deleteFile($item->flag);

            AdminHelper::logPut('Deleted supportedCountries master', MasterSupportedCountriesModel::class, $item->id);

            return redirect()->route('admin.master.supported-countries.index')
                ->with('success', 'supportedCountries deleted successfully.');
        }

        return redirect()->route('admin.master.supported-countries.index')
            ->with('error', 'Item not found');
    }
}
