<?php

namespace App\Http\Controllers;

use App\Helpers\UtillsHelper;
use App\Models\InvestorModel;
use App\Models\NotificationsModel;
use App\Models\PartnerModel;
use App\Models\StartupModel;
use App\Models\UserAdminModel;
use App\Traits\FileUploadTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response as Download;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DownloadController extends Controller
{
    use FileUploadTrait;
    function web(Request $request): RedirectResponse|Response
    {
        if (!$request->has('path') || !$request->has('name')) {
            return redirect()->back()->with('error', 'File not found');
        }
        if (!$this->isFileExists($request->path)) {
            return redirect()->back()->with('error', 'File not found');
        }
        $extension = File::extension($request->path);
        $mime = UtillsHelper::getMIMEFromExtension($extension);
        $headers = [
            'Content-Type'        => 'Content-Type: ' . $mime,
            'Content-Disposition' => 'attachment; filename="' . $request->name . '.' . $extension . '"'
        ];
        return Download::make(Storage::get($request->path), 200, $headers);
    }

    function notifications(Request $request): JsonResponse
    {
        if (Auth::guard('investor')->check()) {
            $notifications = NotificationsModel::where('user_id', Auth::guard('investor')->user()->id)->where('user_type', InvestorModel::class);
        } else if (Auth::guard('startup')->check()) {
            $notifications = NotificationsModel::where('user_id', Auth::guard('startup')->user()->id)->where('user_type', StartupModel::class);
        } else if (Auth::guard('partner')->check()) {
            $notifications = NotificationsModel::where('user_id', Auth::guard('partner')->user()->id)->where('user_type', PartnerModel::class);
        } else if (Auth::guard('admin')->check()) {
            $notifications = NotificationsModel::where('user_id', Auth::guard('admin')->user()->id)->where('user_type', UserAdminModel::class);
        } else {
            $notifications = NotificationsModel::where('user_id', 0);
        }
        $totalCounter =  (clone $notifications)->count();
        $notifications->update(['is_readed' => '1']);
        $notifications = $notifications->orderby('id', 'desc')->limit(6);

        $string = '';
        if ($notifications->count() > 0) {
            foreach ($notifications->get() as $key => $value) {
                if (Auth::guard('admin')->check()) {
                    if ($value->url == 'preipo-transaction') {
                        $route = route('admin.preipotransaction.pending');
                    } else if ($value->url == 'preipo-market') {
                        $route = route('admin.preipotransaction.market');
                    } else {
                        $route = route($value->url);
                    }


                    $string .= '<div class="d-flex flex-stack py-4">';
                    $string .= '    <div class="d-flex align-items-center">';
                    $string .= '        <div class="symbol symbol-35px me-4">';
                    $string .= '            <span class="symbol-label bg-light-primary">' . getIcon('notification-on', 'fs-2 text-primary') . '</span>';
                    $string .= '        </div>';
                    $string .= '        <div class="mb-0 me-2">';
                    $string .= '            <a href="' . $route . '" class="fs-6 text-gray-800 text-hover-primary fw-bold">' . UtillsHelper::read_more_hide($value->title, 25) . '</a>';
                    $string .= '            <div class="text-gray-500 fs-7">' . UtillsHelper::read_more_hide($value->body, 80) . '</div>';
                    $string .= '        </div>';
                    $string .= '    </div>';
                    $string .= '    <span class="badge badge-light fs-8">' . $value->created_at->diffForHumans() . '</span>';
                    $string .= '</div>';
                } else {
                    $string .= '<a href="' . route($value->url) . '"><div class="notification">';
                    $string .= '<div class="name_info">';
                    $string .= '<h4>' . UtillsHelper::read_more_hide($value->title, 25) . '</h4>';
                    $string .= '<p>' . UtillsHelper::read_more_hide($value->body, 100) . '</p>';
                    $string .= '</div>';
                    $string .= '</div></a>';
                }
            }
        } else {
            $string .= '<div class="notification">';
            $string .= '<div class="name_info" style="width:100%;">';
            $string .= '<h4 class="text-center">No notifications found</h4>';
            $string .= '</div>';
            $string .= '</div>';
        }

        return UtillsHelper::json(1, ['list' => $string, 'counter' => $notifications->count(), 'total' => $totalCounter]);
    }
}
