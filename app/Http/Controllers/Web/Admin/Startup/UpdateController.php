<?php

namespace App\Http\Controllers\Web\Admin\Startup;

use App\Enums\Utills\StatusEnum;
use App\Helpers\AdminHelper;
use App\Http\Controllers\Controller;
use App\Models\StartupUpdateModel;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class UpdateController extends Controller
{
    use FileUploadTrait;

    function pending(): View
    {
        setPageTitle('Pending Startup Update Requests');
        $data['list'] = StartupUpdateModel::where('status', StatusEnum::pending)->get();
        return view('admin.pages.startup.update', $data);
    }

    function approved(): View
    {
        setPageTitle('Approved Startup Update');
        $data['list'] = StartupUpdateModel::where('status', StatusEnum::approved)->get();
        return view('admin.pages.startup.update', $data);
    }

    function rejected(): View
    {
        setPageTitle('Rejected Startup Update');
        $data['list'] = StartupUpdateModel::where('status', StatusEnum::rejected)->get();
        return view('admin.pages.startup.update', $data);
    }

    function status($id, $status): RedirectResponse
    {
        $update = StartupUpdateModel::where('id', $id)->first();
        if ($update) {
            $update->status = $status;
            $update->save();

            AdminHelper::logPut('Startup Updates/News Updated to status ' . $status, StartupUpdateModel::class, $update->id);
            return redirect()->back()->with('success', 'Status changed');
        }
        return redirect()->back()->with('error', 'Update not found');
    }

    function delete($id): RedirectResponse
    {
        $update = StartupUpdateModel::where('id', $id)->first();
        if ($update) {
            $this->deleteFile($update->image);
            $update->delete();

            AdminHelper::logPut('Startup Updates/News Deleted', StartupUpdateModel::class, $update->id);

            return redirect()->back()->with('success', 'Update deleted');
        }
        return redirect()->back()->with('error', 'Update not found');
    }
}
