<?php

namespace App\Http\Controllers\Web\Admin;

use App\Helpers\AdminHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\NotificationRequest;
use App\Models\InvestorModel;
use App\Models\NotificationsModel;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class NotificationController extends Controller
{
    function create(): View
    {
        setPageTitle('Notification');
        $data['investors'] = InvestorModel::where('is_deleted', '0')->orderby('id', 'desc')->get();
        return view('admin.pages.notification.create')->with($data);
    }

    function store(NotificationRequest $notificationRequest): RedirectResponse
    {
        $notification = new NotificationsModel();
        $notification->user_id = $notificationRequest->investor_id;
        $notification->user_type = InvestorModel::class;
        $notification->url = 'front.home';
        $notification->title = $notificationRequest->title;
        $notification->body = $notificationRequest->body;
        $notification->save();
        AdminHelper::logPut('Created Notification', NotificationController::class, $notification->id);
        return redirect()->route('admin.notification.investor.create')->with('success', 'Notification created successfully');
    }
}
