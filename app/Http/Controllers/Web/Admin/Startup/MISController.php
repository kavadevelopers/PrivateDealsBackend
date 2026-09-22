<?php

namespace App\Http\Controllers\Web\Admin\Startup;

use App\Enums\Utills\StatusEnum;
use App\Helpers\AdminHelper;
use App\Helpers\FileUpDownHelper;
use App\Helpers\UtillsHelper;
use App\Http\Controllers\Controller;
use App\Models\StartupMisModel;
use App\Models\StartupModel;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class MISController extends Controller
{
    use FileUploadTrait;
    function create(): View
    {
        setPageTitle('Create MIS');
        $data['startups'] = StartupModel::where('is_deleted', '0')->orderby('id', 'desc')->get();
        return view('admin.pages.startup.mis.create', $data);
    }

    function store(Request $request): RedirectResponse
    {
        $validation = Validator::make($request->all(), [
            'title'         => 'required|max:250',
            'document'      => 'required|file|mimes:csv,xlsx,pdf|max:' . UtillsHelper::maxFileDocumentSizeInKB(),
            'description'   => 'required',
            'startup_id'    => 'required'
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput()->with('error', 'Please check form errors');
        }

        $startupMIS = new StartupMisModel();
        $startupMIS->startup_id = $request->startup_id;
        $startupMIS->title = $request->title;
        $startupMIS->description = $request->description;
        if ($request->hasFile('document')) {
            $startupMIS->document = FileUpDownHelper::startup_mis_upload($request->file('document'));
        }
        $startupMIS->status = StatusEnum::approved;
        AdminHelper::logPut('Created MIS', MISController::class, $startupMIS->id);
        $startupMIS->save();

        return redirect()->back()->with('success', 'MIS Uploaded');
    }

    function pending(): View
    {
        setPageTitle('Pending Startup MIS Requests');
        $data['list'] = StartupMisModel::where('status', StatusEnum::pending)->get();
        return view('admin.pages.startup.mis.list', $data);
    }

    function approved(): View
    {
        setPageTitle('Approved Startup MIS');
        $data['list'] = StartupMisModel::where('status', StatusEnum::approved)->get();
        return view('admin.pages.startup.mis.list', $data);
    }

    function rejected(): View
    {
        setPageTitle('Rejected Startup MIS');
        $data['list'] = StartupMisModel::where('status', StatusEnum::rejected)->get();
        return view('admin.pages.startup.mis.list', $data);
    }

    function status($id, $status): RedirectResponse
    {
        $update = StartupMisModel::where('id', $id)->first();
        if ($update) {
            $update->status = $status;
            $update->save();
            AdminHelper::logPut('Startup Mis Updated to status ' . $status, MISController::class, $update->id);
            return redirect()->back()->with('success', 'Status changed');
        }
        return redirect()->back()->with('error', 'MIS not found');
    }

    function delete($id): RedirectResponse
    {
        $update = StartupMisModel::where('id', $id)->first();
        if ($update) {
            $this->deleteFile($update->document);
            $update->delete();
            AdminHelper::logPut('Startup Mis Deleted', MISController::class, $update->id);
            return redirect()->back()->with('success', 'MIS deleted');
        }
        return redirect()->back()->with('error', 'MIS not found');
    }
}
