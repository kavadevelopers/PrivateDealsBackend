<?php

namespace App\Http\Controllers\Web\Admin\Master;

use App\Helpers\AdminHelper;
use App\Helpers\CommonHelper;
use App\Helpers\FileUpDownHelper;
use App\Helpers\UtillsHelper;
use App\Http\Controllers\Controller;
use App\Models\MasterFindCmlModel;
use App\Traits\FileUploadTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class FindCmlController extends Controller
{
    use FileUploadTrait;
    public function create(): View
    {
        addVendor('tinymce');
        setPageTitle('Create Find CML');
        return view('admin.pages.findcml.create');
    }


    public function store(Request $request): RedirectResponse
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'logo' => 'nullable|image|mimes:' . CommonHelper::appSettings('file_image_extensions_allowed') . '|max:' . UtillsHelper::maxFileImageSizeInKB(),
            'description' => 'nullable',
            'video' => 'nullable'
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withInput()
                ->with('error', $validation->errors()->first());
        }

        $findcml = new MasterFindCmlModel();

        if ($request->hasFile('logo')) {
            $findcml->logo = FileUpDownHelper::master_pages_findcml_logo_upload($request->file('logo'));
        }
        if ($request->hasFile('video')) {
            $findcml->video = FileUpDownHelper::master_pages_findcml_video_upload($request->file('video'));
        }
        $findcml->name = $request->name;
        $findcml->description = $request->description;
        $findcml->save();

        AdminHelper::logPut('Created cms Find CML', MasterFindCmlModel::class, $findcml->id);

        return redirect()->route('admin.master.findcml.list')
            ->with('success', 'Created successfully');
    }

    public function list(): View
    {
        setPageTitle('Find CML List');
        $data['list'] = MasterFindCmlModel::where('is_deleted', 0)->latest()->get();
        addVendor('datatables');
        return view('admin.pages.findcml.list', $data);
    }

    public function edit(string $uuid): View|RedirectResponse
    {
        addVendor('tinymce');
        $item = MasterFindCmlModel::where('uuid', $uuid)
            ->where('is_deleted', 0)
            ->first();

        if (!$item) {
            return redirect()->route('admin.master.findcml.list')
                ->with('error', 'Record not found');
        }

        setPageTitle('Edit Find CML');

        return view('admin.pages.findcml.edit', compact('item'));
    }

    public function update(Request $request, string $uuid): RedirectResponse
    {
        $item = MasterFindCmlModel::where('uuid', $uuid)
            ->where('is_deleted', 0)
            ->first();

        if (!$item) {
            return redirect()->route('admin.master.findcml.list')
                ->with('error', 'Record not found');
        }

        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'logo' => 'nullable|image|mimes:' . CommonHelper::appSettings('file_image_extensions_allowed') . '|max:' . UtillsHelper::maxFileImageSizeInKB(),
            'description' => 'nullable',
            'video' => 'nullable'
        ]);

        if ($validation->fails()) {
            return redirect()->back()
                ->withInput()
                ->with('error', $validation->errors()->first());
        }

        DB::beginTransaction();

        try {

            if ($request->hasFile('logo')) {
                if ($item->logo) {
                    $this->deleteFile($item->logo);
                }
                $item->logo = FileUpDownHelper::master_pages_findcml_logo_upload($request->file('logo'));
            }

            if ($request->hasFile('video')) {
                if ($item->video) {
                    $this->deleteFile($item->video);
                }
                $item->video = FileUpDownHelper::master_pages_findcml_video_upload($request->file('video'));
            }

            $item->name = $request->name;
            $item->description = $request->description;
            $item->save();

            AdminHelper::logPut('Updated cms Find CML', MasterFindCmlModel::class, $item->id);

            DB::commit();

            return redirect()->route('admin.master.findcml.list')
                ->with('success', 'Updated successfully');
        } catch (Exception $e) {

            DB::rollBack();

            return back()->with('error', 'Something went wrong');
        }
    }


    public function delete(string $id): RedirectResponse
    {
        $item = MasterFindCmlModel::where('id', $id)
            ->where('is_deleted', 0)
            ->first();

        if (!$item) {
            return back()->with('error', 'Record not found');
        }

        $item->is_deleted = 1;
        $item->save();

        AdminHelper::logPut('Deleted cms Find CML', MasterFindCmlModel::class, $item->id);

        return back()->with('success', 'Deleted successfully');
    }
}
