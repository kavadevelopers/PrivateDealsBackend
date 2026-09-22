<?php

namespace App\Http\Controllers\Web\Admin\Master;

use App\Helpers\AdminHelper;
use App\Helpers\CommonHelper;
use App\Helpers\FileUpDownHelper;
use App\Helpers\UtillsHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Models\MasterIndustryModel;
use Illuminate\Http\Request;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class IndustryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use FileUploadTrait;
    public function index(): View
    {
        setPageTitle('Masters Industry');
        $data['list'] = MasterIndustryModel::where('is_deleted', '0')->orderby('id', 'desc')->get();
        addVendors(['datatables', 'lazy-image']);
        return view('admin.pages.master.industry')->with($data);
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
    public function store(Request $request):RedirectResponse
    {
        $industry = new MasterIndustryModel();
        $validation = Validator::make($request->all(), [
            'name' => [
                'required',
                'max:255',
                'string',
                Rule::unique($industry->getTable())->where(function ($query) use ($request) {
                    return $query->where('is_deleted', '0');
                }),
            ], 'image' => 'nullable|image|mimes:' . CommonHelper::appSettings('file_image_extensions_allowed') . '|max:' . UtillsHelper::maxFileImageSizeInKB(),
            'display_order' => [
                'nullable',
                'integer',
                'min:1',
            ],
        ]);
        if ($validation->fails()) {
            return redirect()->route('admin.master.industry.index')->withInput()
                ->with('error', $validation->errors()->first());
        }

        $industry->name = $request->name;
        $industry->display_order = $request->display_order;
        $industry->url_slug = AdminHelper::sectorSlug(strtolower($request->name));
        if ($request->hasFile('image')) {
            $industry->icon_image = FileUpDownHelper::master_industry_image_upload($request->file('image'));
        }
        $industry->save();

        AdminHelper::logPut('Created industry master', MasterIndustryModel::class, $industry->id);

        return redirect()->route('admin.master.industry.index')
            ->with('success', 'Industry created successfully.');
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
    public function edit(string $id): RedirectResponse|View
    {
        $item = MasterIndustryModel::where('is_deleted', '0')->find($id);
        if ($item) {
            setPageTitle('Masters Industry');
            $data['item'] = $item;
            $data['list'] = MasterIndustryModel::where('is_deleted', '0')->orderby('id', 'desc')->get();
            addVendor('datatables');
            return view('admin.pages.master.industry')->with($data);
        }

        return redirect()->route('admin.master.industry.index')
            ->with('error', 'Item not found');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id):RedirectResponse
    {
        $item = MasterIndustryModel::where('is_deleted', '0')->find($id);
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
                'image' => 'nullable|image|mimes:' . CommonHelper::appSettings('file_image_extensions_allowed') . '|max:' . UtillsHelper::maxFileImageSizeInKB(),
                'display_order' => [
                    'nullable',
                    'integer',
                    'min:1',
                ],
            ]);
            if ($validation->fails()) {
                return redirect()->back()->withInput()
                    ->with('error', $validation->errors()->first());
            }

            $item->name = $request->name;
            $item->url_slug = AdminHelper::sectorSlug(strtolower($request->name));
            if ($request->hasFile('image')) {
                $file = FileUpDownHelper::master_sector_image_upload($request->file('image'));
                if ($file) {
                    $this->deleteFile($item->icon_image);
                    $item->icon_image = $file;
                }
            }
            $item->display_order = $request->display_order;
            $item->update();

            AdminHelper::logPut('Updated industry master', MasterIndustryModel::class, $item->id);

            return redirect()->route('admin.master.industry.index')
                ->with('success', 'Industry updated successfully.');
        }

        return redirect()->route('admin.master.industry.index')
            ->with('error', 'Item not found');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $item = MasterIndustryModel::where('is_deleted', '0')->find($id);

        if ($item) {
            $item->is_deleted = '1';
            $item->update();
            $this->deleteFile($item->icon_image);

            AdminHelper::logPut('Deleted industry master', MasterIndustryModel::class, $item->id);

            return redirect()->route('admin.master.industry.index')
                ->with('success', 'Industry deleted successfully.');
        }

        return redirect()->route('admin.master.industry.index')
            ->with('error', 'Item not found');
    }
}
