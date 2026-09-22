<?php

namespace App\Http\Controllers\Web\Admin\Master;

use App\Helpers\AdminHelper;
use App\Helpers\CommonHelper;
use App\Helpers\FileUpDownHelper;
use App\Helpers\UtillsHelper;
use App\Http\Controllers\Controller;
use App\Models\MasterPagesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PagesController extends Controller
{
    public function index()
    {
        setPageTitle('Pages');
        $data['list'] = MasterPagesModel::where('is_deleted', '0')->orderby('id', 'desc')->get();
        addVendor('datatables');
        return view('admin.pages.cms.pages.list')->with($data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $pages = new MasterPagesModel();
        $validation = Validator::make($request->all(), [
            'name' => [
                'required',
                'max:255',
                'string',

                Rule::unique($pages->getTable())->where(function ($query) use ($request) {
                    return $query->where('is_deleted', '0');
                }),
            ],
        ]);
        if ($validation->fails()) {
            return redirect()->route('admin.cms.pages.index')->withInput()
                ->with('error', $validation->errors()->first());
        }

        $pages->name = strtolower($request->name);
        $pages->is_display_banner = $request->display_order;
        $pages->is_display_title = $request->is_display_title;
        $pages->save();

        return redirect()->route('admin.cms.pages.index')
            ->with('success', 'Pages created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $item = MasterPagesModel::where('is_deleted', '0')->find($id);
        if ($item) {
            setPageTitle('Edit Page');
            $data['item'] = $item;
            $data['list'] = MasterPagesModel::where('is_deleted', '0')->orderby('id', 'desc')->get();
            addVendors(['datatables', 'tinymce']);
            return view('admin.pages.cms.pages.edit')->with($data);
        }

        return redirect()->route('admin.cms.pages.index')
            ->with('error', 'Item not found');
    }

    public function update(Request $request, string $id)
    {
        $item = MasterPagesModel::where('is_deleted', '0')->find($id);
        if ($item) {
            $validation = Validator::make($request->all(), [
                'name' => [
                    'required',
                    'max:255',
                    'string',
                    Rule::unique($item->getTable())->where(function ($query) use ($item) {
                        return $query->where('is_deleted', '0')->where('id', '!=', $item->id);
                    }),
                ], 'banner' => 'nullable|image|mimes:' . CommonHelper::appSettings('file_image_extensions_allowed') . '|max:' . UtillsHelper::maxFileImageSizeInKB(),
                'description'   => 'required'
            ]);
            if ($validation->fails()) {
                return redirect()->back()->withInput()
                    ->with('error', $validation->errors()->first());
            }

            $item->name = $request->name;
            if ($request->hasFile('banner')) {
                $item->banner = FileUpDownHelper::master_pages_banner_upload($request->file('banner'));
            }
            $item->description = $request->description;
            $item->update();

            AdminHelper::logPut('Updated cms pages', MasterPagesModel::class, $item->id);

            return redirect()->route('admin.cms.pages.index')
                ->with('success', 'Pages updated successfully.');
        }

        return redirect()->route('admin.cms.pages.index')
            ->with('error', 'Item not found');
    }

    public function destroy(string $id)
    {
        $item = MasterPagesModel::where('is_deleted', '0')->find($id);

        if ($item) {
            $item->is_deleted = '1';
            $item->update();

            return redirect()->route('admin.cms.pages.index')
                ->with('success', 'Pages deleted successfully.');
        }

        return redirect()->route('admin.cms.pages.index')
            ->with('error', 'Item not found');
    }
}
