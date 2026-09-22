<?php

namespace App\Http\Controllers\Web\Admin;

use App\Helpers\AdminHelper;
use App\Helpers\CommonHelper;
use App\Helpers\FileUpDownHelper;
use App\Helpers\UtillsHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ManagerRequest;
use App\Models\UserAdminModel;
use Illuminate\Http\Request;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class MyProfileController extends Controller
{
    use FileUploadTrait;
    function view(): View
    {
        $user = Auth::guard('admin')->user();
        return view('admin.pages.myprofile.view', compact('user'));
    }

    function edit(): View
    {
        $user = Auth::guard('admin')->user();
        setPageTitle('Edit Profile');
        return view('admin.pages.myprofile.view', compact('user'));
    }

    function update(Request $request): RedirectResponse
    {
        $item = UserAdminModel::where('id', Auth::guard('admin')->user()->id)->first();
        $uuid = $item->id;
        $validation = Validator::make($request->all(), [
            'password' => 'nullable',
            'name'              =>  'required|string|max:255',
            'profile_photo'     =>  'nullable|image|mimes:' . CommonHelper::appSettings('file_image_extensions_allowed') . '|max:' . UtillsHelper::maxFileImageSizeInKB(),
            'username' => [
                'required',
                'alpha_dash',
                'min:4',
                'max:30',
                Rule::unique((new UserAdminModel())->getTable())->where(function ($query) use ($uuid) {
                    if ($uuid) {
                        return $query->where('is_deleted', '0')->where('id', '!=', $uuid);
                    }
                    return $query->where('is_deleted', '0');
                }),
            ],
            'mobile_no' => [
                'required',
                'numeric',
                'digits:10',
                Rule::unique((new UserAdminModel())->getTable())->where(function ($query) use ($uuid) {
                    if ($uuid) {
                        return $query->where('is_deleted', '0')->where('id', '!=', $uuid);
                    }
                    return $query->where('is_deleted', '0');
                }),
            ],

            'email' => [
                'required',
                'email',
                Rule::unique((new UserAdminModel)->getTable())->where(function ($query) use ($uuid) {
                    if ($uuid) {
                        return $query->where('is_deleted', '0')->where('id', '!=', $uuid);
                    }
                    return $query->where('is_deleted', '0');
                }),
            ],
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        if ($item) {
            $item->name = $request->name;
            $item->username = $request->username;
            $item->mobile_no = $request->mobile_no;
            $item->email = $request->email;
            if ($request->password) {
                $item->password = Hash::make($request->password);
            }
            if ($request->hasFile('profile_photo')) {
                $file = FileUpDownHelper::subadmin_profile_photo_upload($request->file('profile_photo'));
                if ($file) {
                    $this->deleteFile($item->profile_photo);
                    $item->profile_photo = $file;
                }
            }
            if ($request->avatar_remove) {
                if ($item->profile_photo != NULL) {
                    $this->deleteFile($item->profile_photo);
                }
                $item->profile_photo = NULL;
            }
            $item->save();
            AdminHelper::logPut('User Updated ' . $item->name . $item->mobile_no, UserAdminModel::class, $item->id);
            return redirect()->route('admin.myprofile.view')->with('success', 'Profile Updated');
        }
    }
}
