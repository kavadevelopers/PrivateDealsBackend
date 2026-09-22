<?php

namespace App\Http\Controllers\Web\Front\User\Startup;

use App\Helpers\FileUpDownHelper;
use App\Http\Controllers\Controller;
use App\Models\StartupModel;
use App\Models\StartupUpdateModel;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class UpdatesController extends Controller
{

    use FileUploadTrait;

    function list(): View
    {
        setPageTitle('Updates');
        $data['list'] = StartupUpdateModel::where('startup_id', Auth::guard('startup')->user()->id)->orderby('id', 'desc')->get();
        return view('front.startup.updates', $data);
    }

    function save(Request $request): RedirectResponse
    {
        $validation = Validator::make($request->all(), [
            'title'         => 'required|max:250',
            'description'   => 'required'
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withInput()->with('error', $validation->errors()->first());
        }

        $startupUpdate = new StartupUpdateModel();
        $startupUpdate->startup_id = Auth::guard('startup')->user()->id;
        $startupUpdate->title = $request->title;
        $startupUpdate->description = $request->description;
        if ($request->hasFile('image')) {
            $startupUpdate->image = FileUpDownHelper::startup_updates_upload($request->file('image'));
        }
        $startupUpdate->save();

        return redirect()->back()->with('success', 'Update Created');
    }

    function delete($id): RedirectResponse
    {
        $row = StartupUpdateModel::where('id', $id)->where('startup_id', Auth::guard('startup')->user()->id)->first();
        if ($row) {
            $this->deleteFile($row->image);
            $row->delete();
            return redirect()->back()->with('success', 'Update Deleted');
        }
        return redirect()->back()->with('error', 'Update not found');
    }
}
