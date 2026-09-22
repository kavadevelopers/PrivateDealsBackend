<?php

namespace App\Http\Controllers\Web\Admin\ProfileMenu;

use App\Http\Controllers\Controller;
use App\Models\NotificationsModel;
use App\Models\UserAdminModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class NotificationController extends Controller
{
    function list(): View
    {
        setPageTitle('Notification');
        $data['list'] = NotificationsModel::where('user_type', UserAdminModel::class)->where('user_id', Auth::guard('admin')->user()->id)->orderBy('id', 'desc')->get();
        return view('admin.pages.profile-menu.notifications.list')->with($data);
    }
}
