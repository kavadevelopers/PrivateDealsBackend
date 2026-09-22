<?php

namespace App\Http\Controllers\Web\Admin;

use App\Enums\MessagesStatusEnum;
use App\Enums\NotificationTypeEnum;
use App\Enums\WpMessageTypeEnum;
use App\Exports\GuestUserTemplateExport;
use App\Helpers\AdminHelper;
use App\Helpers\CommonHelper;
use App\Helpers\DateTimeHelper;
use App\Helpers\FileUpDownHelper;
use App\Helpers\UtillsHelper;
use App\Http\Controllers\Controller;
use App\Jobs\broadcast\Whatsapp;
use App\Models\InvestorModel;
use App\Models\PartnerModel;
use App\Models\PortfolioModel;
use App\Models\ReportMessagesWhatsappModel;
use App\Models\ReportNotificationsModel;
use App\Models\StartupModel;
use App\Models\WhatsappBroadcastModel;
use App\Traits\WhatsAppSendTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Yajra\DataTables\Facades\DataTables;

class WhatsappBroadcastController extends Controller
{
    use WhatsAppSendTrait;
    function list(Request $request): View|JsonResponse
    {
        setPageTitle('Whatsapp Broadcast');

        if ($request->ajax()) {
            $query = WhatsappBroadcastModel::where('is_deleted', 0)
                ->orderby('id', 'desc');

            if ($request->filled('status_filter')) {
            }

            if ($request->filled('template_filter')) {
                $query->where('template_name', 'LIKE', '%' . $request->template_filter . '%');
            }

            try {
                return DataTables::of($query)
                    ->addColumn('broadcast_info', function ($row) {
                        $html = '';
                        if ($row->broadcast_id) {
                            $html .= '<span class="badge badge-info d-block">' . $row->broadcast_id . '</span>';
                            if ($row->connected) {
                                $html .= '<span class="badge badge-warning d-block">' . $row->connected->broadcast_id . '</span>';
                            }
                        }
                        return $html;
                    })
                    ->addColumn('template_name', fn($row) => ucfirst($row->template_name))
                    ->addColumn('recipients_count', fn($row) => $row->recipients_count)
                    ->addColumn('pending_count', fn($row) => $row->pending_count)
                    ->addColumn('sent_count', fn($row) => $row->sent_count)
                    ->addColumn('delivered_count', fn($row) => $row->delivered_count)
                    ->addColumn('seen_count', fn($row) => $row->seen_count)
                    ->addColumn('replied_count', fn($row) => $row->replied_count)
                    ->addColumn('failed_count', fn($row) => $row->failed_count)
                    ->addColumn('created_date', function ($row) {
                        return '<span class="text-muted fw-semibold text-muted d-block fs-7">' .
                            DateTimeHelper::formatDateTime($row->created_at, 'd M Y h:i A') .
                            '</span>';
                    })
                    ->addColumn('action', function ($row) {
                        return view('admin.pages.whatsappBroadcast.partials.actions', compact('row'))->render();
                    })
                    ->filter(function ($query) use ($request) {
                        if ($request->has('search') && !empty($request->search['value'])) {
                            $search = $request->search['value'];
                            $query->where(function ($q) use ($search) {
                                $q->where('template_name', 'LIKE', "%{$search}%")
                                    ->orWhere('broadcast_id', 'LIKE', "%{$search}%");
                            });
                        }
                    })
                    ->rawColumns(['broadcast_info', 'created_date', 'action'])
                    ->make(true);
            } catch (Exception $e) {
                return response()->json(['error' => 'Server Error: ' . $e->getMessage()], 500);
            }
        }

        return view('admin.pages.whatsappBroadcast.list');
    }


    function create(): View
    {
        setPageTitle('Create Whatsapp Broadcast');
        $hiddenPartnerIds = UtillsHelper::hiddenPartnerIds();
        $data['templates'] = self::fetchTemplatesFromApi();
        $data['investors'] = InvestorModel::orderBy('name', 'asc')
            ->where('is_deleted', 0)
            ->when(!empty($hiddenPartnerIds), function ($query) use ($hiddenPartnerIds) {
                $query->where(function ($q) use ($hiddenPartnerIds) {
                    $q->whereNull('partner_id')
                        ->orWhereNotIn('partner_id', $hiddenPartnerIds);
                });
            })
            ->where(function ($q) {
                // Remove investors who have ONLY startup access
                $q->where('is_preipo_access', 1) // keep pre-IPO users
                    ->orWhere(function ($sub) {
                        $sub->where('is_primary_access', 0)
                            ->where('is_secondary_access', 0);
                    });
            })
            ->get();


        $data['partners'] = PartnerModel::orderBy('name', 'asc')
            ->where('is_deleted', 0)
            ->when(!empty($hiddenPartnerIds), function ($query) use ($hiddenPartnerIds) {
                $query->whereNotIn('id', $hiddenPartnerIds);
            })
            ->get();
        $data['startups'] = StartupModel::orderby('brand_name', 'asc')
            ->where('is_deleted', 0)
            ->get();
        return view('admin.pages.whatsappBroadcast.create', $data);
    }

    /**
     * AJAX: Return investor IDs who invested in a given startup.
     *
     * This is used on the broadcast create page when a startup is selected,
     * to auto-check only those investors.
     */
    public function investedInvestors(Request $request): JsonResponse
    {
        $validation = Validator::make($request->all(), [
            'startup_id' => 'required|integer',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validation->errors()->first(),
                'investor_ids' => [],
            ], 422);
        }

        $startup = StartupModel::where('is_deleted', 0)->where('id', $request->startup_id)->first();
        if (!$startup) {
            return response()->json([
                'success' => false,
                'message' => 'Startup not found.',
                'investor_ids' => [],
            ], 404);
        }

        // Portfolio is the canonical "has invested" source in this codebase (startup_id + investor_id).
        $investorIds = PortfolioModel::where('startup_id', $startup->id)
            ->distinct()
            ->pluck('investor_id')
            ->filter()
            ->values();

        return response()->json([
            'success' => true,
            'investor_ids' => $investorIds,
        ]);
    }
    function view(string $item): View|RedirectResponse
    {
        $item = WhatsappBroadcastModel::where('is_deleted', 0)->where('id', $item)->first();
        if ($item) {
            setPageTitle('View ' . $item->template_name . ' Broadcast');
            $data['item'] = $item;
            $data['pending'] = $item->messages()->where('status', MessagesStatusEnum::pending)->get();
            $data['sent'] = $item->messages()->where('status', MessagesStatusEnum::sent)->get();
            $data['delivered'] = $item->messages()->where('status', MessagesStatusEnum::delivered)->get();
            $data['seen'] = $item->messages()->where('status', MessagesStatusEnum::seen)->get();
            $data['failed'] = $item->messages()->where('status', MessagesStatusEnum::failed)->get();
            $data['replied'] = $item->messages()->where('status', MessagesStatusEnum::replied)->get();
            return view('admin.pages.whatsappBroadcast.view', $data);
        }
        return redirect()->back()->with('error', 'Item Not Found');
    }

    function store(Request $request): RedirectResponse
    {

        $validation = Validator::make($request->all(), [
            'template_name'               => 'required',
            'guest_excel'   => 'nullable|file|mimes:xlsx,xls',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withInput()
                ->with('error', 'Please check form errors.')->withErrors($validation);
        }
        // dd($request->all());
        $broadcast = new WhatsappBroadcastModel();
        $broadcast->template_id = $request->template_name;
        $broadcast->template_name = $request->template_name;
        if ($request->hasFile(key: 'header_file')) {
            $broadcast->header_file = FileUpDownHelper::broadcast_header_file_upload($request->file('header_file'));
        }
        if ($request->hasFile('guest_excel')) {
            $collection = Excel::toCollection(null, $request->file('guest_excel'))[0];

            $collection = $collection->slice(1);

            $filtered = $collection->filter(function ($row) {
                return !empty($row[0]) && !empty($row[1]);
            });

            $rowsWithoutKeys = $filtered->map(function ($row) {
                return array_values($row->toArray());
            });

            $broadcast->guest_data = json_encode($rowsWithoutKeys->values());
        } else {
            $broadcast->guest_data = json_encode([]);
        }
        $broadcast->register_guest = $request->has('register_guest') ? 1 : 0;
        if ($request->has('register_guest') && $request->filled('default_button_response')) {
            $broadcast->default_button_response = $request->default_button_response;
            $broadcast->startup_id = $request->filled('selected_startup') ? $request->selected_startup : null;
        }
        $broadcast->dynamic_urls = $request->dynamic_urls;
        $broadcast->variables = $request->variables;
        $broadcast->investors_ids = json_encode($request->selected_investors ?? []);
        $broadcast->partners_ids = json_encode($request->selected_partners ?? []);
        $broadcast->created_by = AdminHelper::getAdmin()->id;
        $broadcast->updated_by = AdminHelper::getAdmin()->id;
        $broadcast->save();
        AdminHelper::logPut('Broadcast created ' . $broadcast->template_name, WhatsappBroadcastModel::class, $broadcast->id);

        Whatsapp::dispatch($broadcast->id);
        return redirect()->route('admin.broadcast.whatsapp.list')->with('success', 'Broadcast Created');
    }

    function resend(Request $request, $item): RedirectResponse
    {
        try {
            $originalBroadcast = WhatsappBroadcastModel::findOrFail($item);

            if ($originalBroadcast->resend_clicked) {
                return redirect()->route('admin.broadcast.whatsapp.list')
                    ->with('info', 'Resend has already been processed for this broadcast.');
            }

            $failedMessages = ReportMessagesWhatsappModel::where('broadcast_id', $originalBroadcast->id)
                ->where('status', MessagesStatusEnum::failed)
                ->get();

            if ($failedMessages->isEmpty()) {
                return redirect()->route('admin.broadcast.whatsapp.list')
                    ->with('info', 'No failed messages found to resend.');
            }
            $originalBroadcast->resend_clicked = true;
            $originalBroadcast->save();

            $newBroadcast = new WhatsappBroadcastModel();
            $newBroadcast->connected_broadcast_id = $originalBroadcast->id;
            $newBroadcast->template_id = $originalBroadcast->template_id;
            $newBroadcast->template_name = $originalBroadcast->template_name;
            $newBroadcast->header_file = $originalBroadcast->header_file;
            $newBroadcast->dynamic_urls = $originalBroadcast->dynamic_urls;
            $newBroadcast->variables = $originalBroadcast->variables;
            $newBroadcast->register_guest = $originalBroadcast->register_guest;
            $newBroadcast->default_button_response = $originalBroadcast->default_button_response;
            $newBroadcast->created_by = AdminHelper::getAdmin()->id;
            $newBroadcast->updated_by = AdminHelper::getAdmin()->id;

            $failedInvestors = [];
            $failedPartners = [];
            $failedGuests = [];

            foreach ($failedMessages as $failedMessage) {
                if ($failedMessage->reference_model === InvestorModel::class) {
                    $failedInvestors[] = $failedMessage->reference_id;
                } elseif ($failedMessage->reference_model === PartnerModel::class) {
                    $failedPartners[] = $failedMessage->reference_id;
                } else {
                    // For guest data (where reference_id and reference_model are null)
                    $failedGuests[] = [$failedMessage->username, $failedMessage->destination_mobile_no];
                }
            }

            $newBroadcast->investors_ids = json_encode(array_unique($failedInvestors));
            $newBroadcast->partners_ids = json_encode(array_unique($failedPartners));
            $newBroadcast->guest_data = json_encode($failedGuests);

            $newBroadcast->save();

            AdminHelper::logPut('New broadcast created for failed messages from: ' . $originalBroadcast->template_name, WhatsappBroadcastModel::class, $newBroadcast->id);

            Whatsapp::dispatch($newBroadcast->id);

            return redirect()->route('admin.broadcast.whatsapp.list')
                ->with('success', "New broadcast created for {$failedMessages->count()} failed messages. Check broadcast: {$newBroadcast->template_name}");
        } catch (\Exception $e) {
            return redirect()->route('admin.broadcast.whatsapp.list')
                ->with('error', 'Error occurred while creating resend broadcast: ' . $e->getMessage());
        }
    }

    function cancel(Request $request, $item): RedirectResponse
    {
        try {
            $broadcast = WhatsappBroadcastModel::findOrFail($item);

            $pendingCount = ReportMessagesWhatsappModel::where('broadcast_id', $broadcast->id)
                ->where('status', MessagesStatusEnum::pending)
                ->count();

            if ($pendingCount === 0) {
                return redirect()->route('admin.broadcast.whatsapp.list')
                    ->with('info', 'No pending messages found to cancel for this broadcast.');
            }

            $cancelledCount = ReportMessagesWhatsappModel::where('broadcast_id', $broadcast->id)
                ->where('status', MessagesStatusEnum::pending)
                ->update([
                    'status' => MessagesStatusEnum::failed,
                    'response' => 'Cancelled by admin',
                    'updated_at' => now()
                ]);

            if ($cancelledCount > 0) {
                AdminHelper::logPut('Broadcast cancelled: ' . $broadcast->template_name . " ({$cancelledCount} messages)", WhatsappBroadcastModel::class, $broadcast->id);

                return redirect()->route('admin.broadcast.whatsapp.list')
                    ->with('success', "Successfully cancelled {$cancelledCount} pending messages for broadcast: {$broadcast->template_name}");
            } else {
                return redirect()->route('admin.broadcast.whatsapp.list')
                    ->with('info', 'No messages were cancelled.');
            }
        } catch (\Exception $e) {
            return redirect()->route('admin.broadcast.whatsapp.list')
                ->with('error', 'Error occurred while cancelling broadcast: ' . $e->getMessage());
        }
    }
    function notificationlist(): View
    {
        setPageTitle(' Notification List');
        // $data['templates'] = self::fetchTemplatesFromApi();
        $data['list'] = ReportNotificationsModel::with('user')->where('response_code', '200')->get();
        return view('admin.pages.whatsappBroadcast.notificationList', $data);
    }

    public function downloadGuestTemplate()
    {
        return Excel::download(new GuestUserTemplateExport(), 'guest_users_template.xlsx');
    }

    public function uploadGuestExcel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:xlsx,csv,xls|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'message' => $validator->errors()->first()
            ]);
        }

        try {
            $data = Excel::toArray([], $request->file('file'));

            if (empty($data) || !isset($data[0]) || count($data[0]) < 2) {
                return response()->json(['status' => 0, 'message' => 'Invalid or empty Excel file']);
            }

            $sheet = $data[0]; // First sheet
            $header = array_map('strtolower', $sheet[0]);

            // Find required columns
            $nameIndex = array_search('name', $header);
            $mobileIndex = array_search('mobile number', $header);

            if ($nameIndex === false || $mobileIndex === false) {
                return response()->json(['status' => 0, 'message' => 'Excel must contain "Name" and "Mobile Number" columns']);
            }

            $guestData = [];

            foreach (array_slice($sheet, 1) as $row) {
                $name = $row[$nameIndex] ?? null;
                $mobile = $row[$mobileIndex] ?? null;

                if ($name && $mobile && is_numeric($mobile)) {
                    $guestData[] = [
                        'name'   => trim($name),
                        'mobile' => trim($mobile),
                    ];
                }
            }

            if (empty($guestData)) {
                return response()->json(['status' => 0, 'message' => 'No valid guest data found']);
            }

            // Create new record in the broadcast_whatsapp table
            $broadcast = new WhatsappBroadcastModel();
            $broadcast->template_name  = $request->template_name ?? null;
            $broadcast->template_id    = $request->template_id ?? null;

            if ($request->hasFile('header_file')) {
                $broadcast->header_file = FileUpDownHelper::broadcast_header_file_upload($request->file('header_file'));
            }

            $broadcast->dynamic_urls   = $request->dynamic_urls ?? null;
            $broadcast->variables      = $request->variables ?? null;
            $broadcast->investors_ids  = json_encode($request->selected_investors ?? []);
            $broadcast->partners_ids   = json_encode($request->selected_partners ?? []);
            $broadcast->guest_data     = json_encode($guestData);
            $broadcast->created_by     = AdminHelper::getAdmin()->id;
            $broadcast->updated_by     = AdminHelper::getAdmin()->id;
            $broadcast->save();

            return response()->json(['status' => 1, 'message' => 'Guest user data uploaded and saved successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 0, 'message' => 'Error processing file: ' . $e->getMessage()]);
        }
    }
}
