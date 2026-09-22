<?php

namespace App\Http\Controllers\Web\Admin\Master;

use App\Helpers\AdminHelper;
use App\Helpers\CommonHelper;
use App\Helpers\FileUpDownHelper;
use App\Helpers\UtillsHelper;
use App\Http\Controllers\Controller;
use App\Models\MasterAvtarModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Traits\FileUploadTrait;

class AvtarController extends Controller
{
    use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        setPageTitle('Avtar');
        $data['list'] = MasterAvtarModel::where('is_deleted', '0')->orderby('display_order', 'desc')->get();
        addVendor('datatables');
        return view('admin.pages.cms.avtar.list')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        setPageTitle('Create Avtar');
        addVendor('tinymce');
        return view('admin.pages.cms.avtar.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $avtar = new MasterAvtarModel();
        if (in_array((int)$request->display_order, [1, 2, 3])) {
            return redirect()->back()->withInput()->with('error', 'Cannot use display order 1, 2, or 3. These are reserved.');
        }
        $validation = Validator::make($request->all(), [

            'avtar_img' => 'required|image|mimes:' . CommonHelper::appSettings('file_image_extensions_allowed') . '|max:' . UtillsHelper::maxFileImageSizeInKB(),
            'display_order' => [
                'nullable',
                'integer',
                'min:1',
                // 'not_in:1,2,3',
            ],
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withInput()
                ->with('error', $validation->errors()->first());
        }

        if ($request->hasFile('avtar_img')) {
            $avtar->avtar_img = FileUpDownHelper::master_pages_avtar_img_upload($request->file('avtar_img'));
        }
        $avtar->display_order = $request->display_order;
        $avtar->save();

        AdminHelper::logPut('Created cms Avtar', MasterAvtarModel::class, $avtar->id);

        return redirect()->route('admin.cms.avtar.index')
            ->with('success', 'Avtar created successfully.');
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
    public function edit(string $uuid)
    {
        $item = MasterAvtarModel::where('uuid', $uuid)->where('is_deleted', '0')->first();
        if ($item) {
            setPageTitle('Edit Avtar');
            $data['item'] = $item;
            $data['list'] = MasterAvtarModel::where('is_deleted', '0')->orderby('id', 'desc')->get();
            addVendor('tinymce');
            return view('admin.pages.cms.avtar.edit')->with($data);
        }

        return redirect()->route('admin.cms.avtar.index')
            ->with('error', 'Item not found');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $uuid)
    {
        $item = MasterAvtarModel::where('uuid', $uuid)->where('is_deleted', '0')->first();
        if ($item) {
            // if (in_array((int)$request->display_order, [1, 2, 3])) {
            //     return redirect()->back()->withInput()->with('error', 'Cannot use display order 1, 2, or 3. These are reserved.');
            // }
            $validation = Validator::make($request->all(), [

                'avtar_img' => 'nullable|image|mimes:' . CommonHelper::appSettings('file_image_extensions_allowed') . '|max:' . UtillsHelper::maxFileImageSizeInKB(),
                'display_order' => [
                    'nullable',
                    'integer',
                    'min:1',
                    // 'not_in:1,2,3',
                ],
            ]);
            if ($validation->fails()) {
                return redirect()->back()->withInput()
                    ->with('error', $validation->errors()->first());
            }

            if ($request->hasFile('avtar_img')) {
                $this->deleteFile($item->avtar_img);
                $item->avtar_img = FileUpDownHelper::master_pages_avtar_img_upload($request->file('avtar_img'));
            }
            $item->display_order = $request->display_order;
            $item->update();
            AdminHelper::logPut('Updated cms avtar', MasterAvtarModel::class, $item->id);

            return redirect()->route('admin.cms.avtar.index')
                ->with('success', 'Avtar updated successfully.');
        }

        return redirect()->route('admin.cms.avtar.index')
            ->with('error', 'Item not found');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uuid)
    {
        $item = MasterAvtarModel::where('uuid', $uuid)->where('is_deleted', '0')->first();

        if ($item) {
            // $this->deleteFile($item->avtar_img);
            $item->is_deleted = '1';
            $item->update();

            AdminHelper::logPut('Deleted cms avtar', MasterAvtarModel::class, $item->id);

            return redirect()->route('admin.cms.avtar.index')
                ->with('success', 'Avtar deleted successfully.');
        }

        return redirect()->route('admin.cms.avtar.index')
            ->with('error', 'Item not found');
    }
}
