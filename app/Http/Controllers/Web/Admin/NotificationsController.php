<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReportMessagesWhatsappModel;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationsController extends Controller
{
    function whatsappList(): View
    {
        setPageTitle('Whatsapp');
        $data['list'] = ReportMessagesWhatsappModel::select(['template_name', 'status', 'destination_mobile_no', 'username'])->whereNull('broadcast_id')->orderby('id', 'desc')->limit(200)->get();
        return view('admin.pages.reports.notifications.whatsapp', $data);
    }
}
