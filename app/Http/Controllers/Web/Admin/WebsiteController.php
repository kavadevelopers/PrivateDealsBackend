<?php

namespace App\Http\Controllers\Web\Admin;

use App\Helpers\AdminHelper;
use App\Helpers\CommonHelper;
use App\Helpers\FileUpDownHelper;
use App\Helpers\UtillsHelper;
use App\Http\Controllers\Controller;
use App\Models\WebsiteMediaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class WebsiteController extends Controller
{
    function create(): View
    {
        setPageTitle('Create Media');
        // $data['cities'] = MasterCityModel::where('is_deleted', '0')->orderby('id', 'desc')->get();
        return view('admin.pages.media.create');
    }

    function store(Request $request): RedirectResponse
    {
        $validation = Validator::make($request->all(), [
            'title'               => 'required',
            'url'                 => 'required',
            'banner'              => 'required|image|mimes:' . CommonHelper::appSettings('file_image_extensions_allowed') . '|max:' . UtillsHelper::maxFileImageSizeInKB(),
            'description'         => 'required',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withInput()
                ->with('error', 'Please check form errors.')->withErrors($validation);
        }

        $media = new WebsiteMediaModel();
        $media->title = $request->title;
        $media->url = $request->url;
        if ($request->hasFile('banner')) {
            $media->banner = FileUpDownHelper::website_banner_upload($request->file('banner'));
        }
        $media->description = $request->description;
        $media->save();
        AdminHelper::logPut('Media created ' . $media->title . $media->description, WebsiteMediaModel::class, $media->id);
        return redirect()->route('admin.cms.media.list')->with('success', 'Media Created');
    }

    function list(): View
    {
        setPageTitle('Media');
        $data['list'] = WebsiteMediaModel::where('is_deleted', '0')->get();
        addVendor('datatables');
        return view('admin.pages.media.list')->with($data);
    }

    function delete(string $id): RedirectResponse
    {
        $item = WebsiteMediaModel::where('is_deleted', '0')->find($id);

        if ($item) {
            // $this->deleteFile($item->banner);
            $item->is_deleted = '1';
            $item->update();
            AdminHelper::logPut('Deleted Media', WebsiteMediaModel::class, $item->id);
            return redirect()->route('admin.cms.media.list')
                ->with('success', 'Media deleted.');
        }

        return redirect()->route('admin.cms.media.list')->with('error', 'Item not found');
    }
}
