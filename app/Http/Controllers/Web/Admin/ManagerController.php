<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\AdminHelper;
use App\Http\Requests\ManagerRequest;
use App\Models\UserAdminModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Spatie\Permission\Models\Permission;

class ManagerController extends Controller
{
    function list(): View
    {
        setPageTitle('Admin List');
        $users = UserAdminModel::where('is_deleted', 0)->where('id', '!=', '1')->get();
        return view('admin.pages.manager.list', compact('users'));
    }

    function create(): View
    {
        setPageTitle('Create Admin');
        $permissions = Permission::where('guard_name', 'admin')->get();
        return view('admin.pages.manager.create', compact('permissions'));
    }

    function edit(string $uuid): View|RedirectResponse
    {
        $item = UserAdminModel::where('is_deleted', '0')->where('uuid', $uuid)->first();
        if ($item) {
            setPageTitle('Edit User');
            $permissions = Permission::where('guard_name', 'admin')->get();
            // $data['item'] = $item;
            // $data['list'] = InvestorModel::where('is_deleted', '0')->orderby('id', 'desc')->get();
            return view('admin.pages.manager.edit', compact('item', 'permissions'));
        }

        return redirect()->route('admin.manager.list')->with('error', 'Item not found');
    }

    function store(ManagerRequest $managerRequest): RedirectResponse
    {
        // dd($managerRequest->all());

        $user = new UserAdminModel();
        $user->role = $managerRequest->role;
        $user->name = $managerRequest->name;
        $user->username = $managerRequest->username;
        $user->mobile_no = $managerRequest->mobile_no;
        $user->email = $managerRequest->email;
        $user->password = Hash::make($managerRequest->password);
        $user->save();

        $user->givePermissionTo($managerRequest->permissions);

        AdminHelper::logPut('User created ' . $user->name . $user->mobile_no, UserAdminModel::class, $user->id);
        return redirect()->route('admin.manager.list')->with('success', 'User Created');
    }

    function update(ManagerRequest $managerRequest, string $uuid): RedirectResponse
    {
        $item = UserAdminModel::where('is_deleted', '0')->where('uuid', $uuid)->first();

        if ($item) {
            $item->role = $managerRequest->role;
            $item->name = $managerRequest->name;
            $item->username = $managerRequest->username;
            $item->mobile_no = $managerRequest->mobile_no;
            $item->email = $managerRequest->email;
            if ($managerRequest->password) {
                $item->password = Hash::make($managerRequest->password);
            }
            $item->save();
            $item->syncPermissions($managerRequest->permissions);
            AdminHelper::logPut('User Updated ' . $item->name . $item->mobile_no, UserAdminModel::class, $item->id);
            return redirect()->route('admin.manager.list')->with('success', 'User Updated');
        }
    }
    function delete(string $id): RedirectResponse
    {
        $user = UserAdminModel::where('is_deleted', '0')->find($id);

        if ($user) {
            $user->is_deleted = '1';
            $user->update();

            AdminHelper::logPut('Deleted User', UserAdminModel::class, $user->id);
            return redirect()->route('admin.manager.list')->with('success', 'User Deleted');
        }

        return redirect()->route('admin.manager.list')->with('error', 'User not found');
    }
}
