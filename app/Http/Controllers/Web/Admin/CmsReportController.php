<?php

namespace App\Http\Controllers\Web\Admin;

use App\Exports\CmsContactExport;
use App\Helpers\AdminHelper;
use App\Helpers\DateTimeHelper;
use App\Helpers\UtillsHelper;
use App\Http\Controllers\Controller;
use App\Jobs\backend\auth\RequestAceessApproveJob;
use App\Models\ApiLogModel;
use App\Models\BetaTestingModel;
use App\Models\CmsContactModel;
use App\Models\CmsFeedbackModel;
use App\Models\InvestorModel;
use App\Models\InvestorRegisterRequestModel;
use App\Models\LeadsModel;
use App\Models\PartnerModel;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Exports\PreIpoDeviceExport;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class CmsReportController extends Controller
{

    function reportLeads(): View
    {
        setPageTitle('Leads');
        $data['list'] = LeadsModel::orderby('id', 'desc')->limit(500)->get();
        return view('admin.pages.reports.leads')->with($data);
    }

    function feedbacklist(): View
    {
        setPageTitle('Feedback');
        $data['list'] = CmsFeedbackModel::orderby('id', 'desc')->limit(200)->get();
        return view('admin.pages.reports.feedback.list')->with($data);
    }

    function contactlist(Request $request): View|JsonResponse
    {
        setPageTitle('Contact');

        if ($request->ajax()) {
            $query = CmsContactModel::where('is_deleted', 0);

            try {
                return DataTables::of($query)
                    ->addColumn('checkbox', function ($row) {
                        return '<div class="form-check form-check-sm form-check-custom form-check-solid d-flex justify-content-center">
                            <input class="form-check-input contact-checkbox" type="checkbox" value="' . $row->id . '" />
                        </div>';
                    })
                    ->addColumn('name', function ($row) {
                        $name = trim(ucfirst($row->firstname ?? ''));
                        $company = trim(ucfirst($row->company ?? ''));

                        $html = '<div class="fw-bold text-gray-800">' . e($name !== '' ? $name : '—') . '</div>';
                        if ($company !== '') {
                            $html .= '<div class="text-muted fs-7">' . e($company) . '</div>';
                        }

                        return $html;
                    })
                    ->addColumn('mobile_no', fn($row) => $row->mobile_no ?: '—')
                    ->addColumn('subject', fn($row) => $row->subject ? ucfirst($row->subject) : '—')
                    ->addColumn('date_time', function ($row) {
                        return $row->created_at
                            ? DateTimeHelper::formatDateTime($row->created_at, 'd M Y, h:i A')
                            : '—';
                    })
                    ->addColumn('action', function ($row) {
                        return view('admin.pages.reports.contact.partials.actions', compact('row'))->render();
                    })
                    ->filter(function ($query) use ($request) {
                        if ($request->has('search') && !empty($request->search['value'])) {
                            $search = $request->search['value'];
                            $query->where(function ($q) use ($search) {
                                $q->where('firstname', 'LIKE', "%{$search}%")
                                    ->orWhere('company', 'LIKE', "%{$search}%")
                                    ->orWhere('mobile_no', 'LIKE', "%{$search}%")
                                    ->orWhere('subject', 'LIKE', "%{$search}%");
                            });
                        }
                    })
                    ->rawColumns(['checkbox', 'name', 'action'])
                    ->make(true);
            } catch (Exception $e) {
                return response()->json(['error' => 'Server Error: ' . $e->getMessage()], 500);
            }
        }

        return view('admin.pages.reports.contact.list');
    }

    public function viewContact(string $id): JsonResponse
    {
        $item = CmsContactModel::where('id', $id)
            ->where('is_deleted', 0)
            ->first();

        if (!$item) {
            return UtillsHelper::json(0, ['message' => 'Record not found'], 404);
        }

        $name = trim(ucfirst($item->firstname ?? ''));

        return UtillsHelper::json(1, [
            'data' => [
                'name' => $name !== '' ? $name : '—',
                'company' => $item->company ? ucfirst($item->company) : '—',
                'email' => $item->email ?: '—',
                'mobile_no' => $item->mobile_no ?: '—',
                'subject' => $item->subject ? ucfirst($item->subject) : '—',
                'description' => $item->description ?: '—',
                'user_type' => $item->user_type ? ucfirst($item->user_type) : '—',
                'date_time' => $item->created_at
                    ? DateTimeHelper::formatDateTime($item->created_at, 'd M Y, h:i A')
                    : '—',
            ],
        ]);
    }

    public function deleteContact(string $id): JsonResponse
    {
        $item = CmsContactModel::where('id', $id)
            ->where('is_deleted', 0)
            ->first();

        if (!$item) {
            return UtillsHelper::json(0, ['message' => 'Record not found'], 404);
        }

        $item->is_deleted = 1;
        $item->save();

        AdminHelper::logPut('Deleted CMS Contact', CmsContactModel::class, $item->id);

        return UtillsHelper::json(1, ['message' => 'Deleted successfully']);
    }

    public function bulkDeleteContact(Request $request): JsonResponse
    {
        $validation = Validator::make($request->all(), [
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:cms_contact,id',
        ]);

        if ($validation->fails()) {
            return UtillsHelper::json(0, ['errors' => $validation->errors()], 422);
        }

        $items = CmsContactModel::whereIn('id', $request->ids)
            ->where('is_deleted', 0)
            ->get();

        if ($items->isEmpty()) {
            return UtillsHelper::json(0, ['message' => 'No records found to delete'], 404);
        }

        foreach ($items as $item) {
            $item->is_deleted = 1;
            $item->save();
            AdminHelper::logPut('Deleted CMS Contact', CmsContactModel::class, $item->id);
        }

        return UtillsHelper::json(1, [
            'message' => $items->count() . ' record(s) deleted successfully',
        ]);
    }

    public function exportContactExcel(Request $request)
    {
        return Excel::download(new CmsContactExport($request), 'contacts.xlsx');
    }

    function requestBetaAccessList(): View
    {
        setPageTitle('Request Access');
        $data['list'] = BetaTestingModel::orderby('id', 'desc')->limit(200)->get();
        return view('admin.pages.reports.beta-access.list')->with($data);
    }

    function requestAccessList(Request $request): View
    {
        if ($request->routeIs('admin.reports.cms.requestaccess.pending')) {
            setPageTitle('Pending Request');
            $data['list'] = InvestorRegisterRequestModel::where('is_readed', 0)->orderby('id', 'desc')->limit(200)->get();
        }
        if ($request->routeIs('admin.reports.cms.requestaccess.completed')) {
            setPageTitle('Completed Request');
            $data['list'] = InvestorRegisterRequestModel::where('is_readed', 1)->orderby('id', 'desc')->limit(200)->get();
        }
        return view('admin.pages.reports.request-access.list', $data);
    }

    function markAsRead(Request $request): JsonResponse
    {
        $validation = Validator::make($request->all(), [
            'notes' => 'required'
        ]);
        if ($validation->fails()) {
            return UtillsHelper::json(0, ['errors' => $validation->errors()], 422);
        }
        $entry = InvestorRegisterRequestModel::find($request->entry_id);
        if ($entry) {
            AdminHelper::logPut('Register request read', InvestorRegisterRequestModel::class, $entry->id);
            $entry->notes = $request->notes;
            $entry->is_readed = 1;

            if ($request->has('is_converted')) {
                $entry->is_converted = 1;
                RequestAceessApproveJob::dispatch($entry->id);
            }

            $entry->save();
            return UtillsHelper::json(1, ['message' => 'Note saved successfully', 'entry_id' => $request->entry_id, 'is_converted' => $request->has('is_converted')], 200);
        } else {
            return UtillsHelper::json(0, ['message' => 'Entry not found'], 404);
        }
    }


    function appLogs(Request $request): View
    {
        $list = ApiLogModel::query(); // Initialize the query builder

        $list->where('useragent', 'NOT LIKE', '%PostmanRuntime%')
            ->where('url', 'NOT LIKE', '%get-config%');

        $title = '';

        if ($request->routeIs('admin.reports.applogs.investor.*')) {
            $title = 'Investor';
            $list->where('usertype', 'investor');
        }

        if ($request->routeIs('admin.reports.applogs.distributer.*')) {
            $title = 'Wealth Manager';
            $list->whereIn('usertype', ['wealthManager', 'distributor']);
        }

        if ($request->routeIs('admin.reports.applogs.investor.android') || $request->routeIs('admin.reports.applogs.distributer.android')) {
            $title .= ' Android';
            $list->where('devicetype', 'android');
        }

        if ($request->routeIs('admin.reports.applogs.investor.ios') || $request->routeIs('admin.reports.applogs.distributer.ios')) {
            $title .= ' Apple iOS';
            $list->where('devicetype', 'ios');
        }

        if ($request->routeIs('admin.reports.applogs.investor.windows') || $request->routeIs('admin.reports.applogs.distributer.windows')) {
            $title .= ' Windows';
            $list->where('devicetype', 'desktop');
        }

        $title .= ' Application Logs';

        setPageTitle($title);

        $data['list'] = $list->orderBy('created_at', 'desc')
            ->limit(1000)
            ->get();

        return view('admin.pages.reports.application-logs')->with($data);
    }

    function activeTodayList(): View
    {
        $demoInvestorIds = InvestorModel::where('is_demo', '1')->pluck('id')->toArray();
        $demoPartnerIds = PartnerModel::where('is_demo', '1')->pluck('id')->toArray();
        $date = request()->date;
        if ($date && strtotime($date) !== false) {
            $validatedDate = Carbon::parse($date)->format('Y-m-d');
        } else {
            $validatedDate = Carbon::today()->format('Y-m-d');
        }
        $list = ApiLogModel::query();

        $list->where('useragent', 'NOT LIKE', '%PostmanRuntime%');

        if (request()->routeIs('admin.reports.applogs.investor.*')) {
            setPageTitle('Investors Active on ' . Carbon::parse($validatedDate)->format('d-m-Y'));
            $list->where('usertype', 'investor')->wherenotin('userid', $demoInvestorIds);
        }
        if (request()->routeIs('admin.reports.applogs.distributer.*')) {

            setPageTitle('Partners Active on ' . Carbon::parse($validatedDate)->format('d-m-Y'));
            $list->wherein('usertype', ['wealthManager', 'distributor'])->wherenotin('userid', $demoPartnerIds);
        }


        $data['list'] = $list->whereDate('created_at', $validatedDate)->whereNotNull('userid')
            ->where('userid', '!=', '')->where('userid', '!=', '0')
            ->select('userid', 'useragent', 'url', 'usertype', 'devicetype', 'created_at')
            ->groupBy('userid')
            ->orderBy('created_at', 'asc')
            ->limit(1000)
            ->get();


        return view('admin.pages.reports.track-active-logs.list')->with($data);
    }

    function activeTodayView($userid, $usertype, $date): View|RedirectResponse
    {
        $validatedDate = $date && strtotime($date) !== false
            ? Carbon::parse($date)->format('Y-m-d')
            : Carbon::today()->format('Y-m-d');

        $list = ApiLogModel::where('userid', $userid)
            ->where('usertype', $usertype)
            ->whereDate('created_at', $validatedDate)
            ->get();

        if ($list->isEmpty()) {
            return redirect()->back()->with('error', 'Something went wrong');
        }

        $item = $list->first();
        $userName = $item->user->name ?? 'N/A';
        $pageTitle = request()->routeIs('admin.reports.applogs.investor.*')
            ? $userName . ' Investor Journey on ' . Carbon::parse($validatedDate)->format('d-m-Y')
            : $userName . ' Distributer Journey on ' . Carbon::parse($validatedDate)->format('d-m-Y');

        setPageTitle($pageTitle);
        $data = AdminHelper::apiLogsToScreenName($list);
        // dd($data);
        // return view('admin.pages.reports.track-active-logs.view', ['list' => $list]);
        return view('admin.pages.reports.track-active-logs.view', ['list' => $data]);
    }

    function preIpoDeviceExport()
    {
        return Excel::download(new PreIpoDeviceExport, 'preipo-device-report-' . date('Y-m-d') . '.xlsx');
    }
}
