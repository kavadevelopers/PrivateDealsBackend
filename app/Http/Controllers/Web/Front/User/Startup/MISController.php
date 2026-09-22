<?php

namespace App\Http\Controllers\Web\Front\User\Startup;

use App\Helpers\FileUpDownHelper;
use App\Http\Controllers\Controller;
use App\Models\StartupMisModel;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class MISController extends Controller
{
    use FileUploadTrait;

    function list(): View
    {
        setPageTitle('MIS');
        $data['list'] = StartupMisModel::where('startup_id', Auth::guard('startup')->user()->id)->orderby('id', 'desc')->get();
        return view('front.startup.mis', $data);
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

        $startupMIS = new StartupMisModel();
        $startupMIS->startup_id = Auth::guard('startup')->user()->id;
        $startupMIS->title = $request->title;
        $startupMIS->description = $request->description;
        if ($request->hasFile('document')) {
            $startupMIS->document = FileUpDownHelper::startup_mis_upload($request->file('document'));
        }
        $startupMIS->save();

        return redirect()->back()->with('success', 'MIS Uploaded');
    }

    function delete($id): RedirectResponse
    {
        $row = StartupMisModel::where('id', $id)->where('startup_id', Auth::guard('startup')->user()->id)->first();
        if ($row) {
            $this->deleteFile($row->document);
            $row->delete();
            return redirect()->back()->with('success', 'MIS Deleted');
        }
        return redirect()->back()->with('error', 'MIS not found');
    }
}
