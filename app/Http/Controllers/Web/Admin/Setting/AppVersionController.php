<?php

namespace App\Http\Controllers\Web\Admin\Setting;

use App\Enums\Utills\DeviceTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\AppVersionControlModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AppVersionController extends Controller
{
    function list(): View
    {
        setPageTitle('Application Version Control');
        $data['list'] = AppVersionControlModel::orderby('id', 'desc')->get();
        return view('admin.pages.setting.app-version-control.list', $data);
    }

    function create(): View
    {
        setPageTitle('Update Version');
        return view('admin.pages.setting.app-version-control.create');
    }

    function store(Request $request): RedirectResponse
    {
        $validation = Validator::make($request->all(), [
            'title'                    => 'required|max:255|string',
            'force_update'             => 'required|in:Yes,No',
            'description'              => 'required',
            'last_version_code'        => 'required|integer',
            'current_version_code'     => 'required|integer',
            'last_version'             => ['required', 'regex:/^\d{1,4}(\.\d{1,4})*$/'],
            'current_version'          => ['required', 'regex:/^\d{1,4}(\.\d{1,4})*$/'],
            'user_type'                => 'required|in:investor,distributer,startup,admin',
            'device_type'              => [
                'required',
                Rule::in(array_column(DeviceTypeEnum::cases(), 'value')),
            ]
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withInput()
                ->with('error', 'Please check form errors.')->withErrors($validation);
        }

        AppVersionControlModel::create([
            'device'               => $request->device_type,
            'last_version_code'    => $request->last_version_code,
            'current_version_code' => $request->current_version_code,
            'last_version'         => $request->last_version,
            'current_version'      => $request->current_version,
            'force_update'         => $request->force_update === 'Yes' ? true : false,
            'app_type'             => $request->user_type,
            'title'                => $request->title,
            'description'          => $request->description,
        ]);

        return redirect()->route('admin.systemConfiguration.appVersionControl.list')->with('success', 'Version Updated');
    }
}
