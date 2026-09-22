<?php

namespace App\Http\Controllers\Web\Admin;

use App\Enums\PreIpoCategoryEnum;
use App\Enums\SendToUserTypeEnum;
use App\Helpers\AdminHelper;
use App\Helpers\CommonHelper;
use App\Helpers\FileUpDownHelper;
use App\Helpers\UtillsHelper;
use App\Http\Controllers\Controller;
use App\Jobs\broadcast\PushNotificationJob;
use App\Models\BroadcastNotificationModel;
use App\Models\CompanyModel;
use App\Models\CompanyNewsModel;
use App\Models\InvestorModel;
use App\Models\PartnerModel;
use App\Models\PreIpoModel;
use App\Models\StartupModel;
use App\Models\StartupPitchModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PushNotificationController extends Controller
{
    function list(): View
    {
        setPageTitle('Push Notification');
        $data['list'] = BroadcastNotificationModel::where('is_deleted', 0)
            ->orderby('id', 'desc')
            ->get();
        return view('admin.pages.pushNotification.list', $data);
    }

    function create(): View
    {
        setPageTitle('Create Push Notification Broadcast');
        $data['investors'] = InvestorModel::orderby('name', 'asc')->where('is_deleted', 0)->get();
        $data['partners'] = PartnerModel::orderby('name', 'asc')->where('is_deleted', 0)->get();
        $data['startups'] = StartupModel::where('is_deleted', 0)->orderby('brand_name', 'asc')->get();
        $data['companies'] = CompanyModel::where('is_deleted', 0)->where('category', '!=', PreIpoCategoryEnum::listed->value)->orderby('brand_name', 'asc')->get();
        $data['pitches'] = StartupPitchModel::where('is_deleted', 0)->orderby('scheduled_date', 'desc')->get();
        $data['news'] = CompanyNewsModel::orderByDesc('created_at')->limit(50)->get();
        $data['preipo_transactions'] = PreIpoModel::with('company')
            ->orderBy('created_at', 'desc')
            ->limit(100)
            ->get();
        return view('admin.pages.pushNotification.create', $data);
    }

    function store(Request $request): RedirectResponse
    {
        // dd($request->all());
        $validation = Validator::make($request->all(), [
            'title'               => 'required',
            'body'               => 'required',
            'image' => 'nullable|image|mimes:' . CommonHelper::appSettings('file_image_extensions_allowed') . '|max:300',
            'send_to' => [
                'required',
                Rule::in(array_column(SendToUserTypeEnum::cases(), 'value')),
            ],
            // 'topic' => [
            //     Rule::requiredIf(fn () => $request->send_to === SendToUserTypeEnum::topic->value),
            // ],
            // 'redirect_to' => 'nullable|string|in:home/primary,home/pre-ipo,home/primary/startupdetail,home/pre-ipo/companydetail,home/livepitch,home/livepitch/detail,home/pre-ipo/news',
            'redirect_to' => 'nullable|string|in:home/primary,home/pre-ipo,home/primary/startupdetail,home/pre-ipo/companydetail,home/livepitch,home/livepitch/detail,home/pre-ipo/news,home/pre-ipo/transactiondetail,home/kyc',
            'specific_startup_id' => [
                Rule::requiredIf($request->input('redirect_to') === 'home/primary/startupdetail'),
                'nullable',
                'exists:startup,id',
            ],

            'specific_company_id' => [
                Rule::requiredIf($request->input('redirect_to') === 'home/pre-ipo/companydetail'),
                'nullable',
                'exists:company,id',
            ],

            'specific_pitch_id' => [
                Rule::requiredIf($request->input('redirect_to') === 'home/livepitch/detail'),
                'nullable',
                'exists:startup_pitch,id',
            ],
            'specific_news_id' => [
                Rule::requiredIf($request->input('redirect_to') === 'home/pre-ipo/news'),
                'nullable',
                'exists:company_news,id',
            ],
            'specific_preipo_transaction_id' => [
                Rule::requiredIf($request->input('redirect_to') === 'home/pre-ipo/transactiondetail'),
                'nullable',
                'exists:pre_ipo_transaction,id',
            ],

        ], [
            'specific_startup_id.required' => 'Please select a startup to redirect to.',
            'specific_company_id.required' => 'Please select a company to redirect to.',
            'specific_pitch_id.required' => 'Please select a pitch to redirect to.',
            'specific_news_id.required' => 'Please select a news item to redirect to.',
            'specific_preipo_transaction_id.required' => 'Please select a transaction to redirect to.',
            'specific_startup_id.exists' => 'The selected startup does not exist.',
            'specific_company_id.exists' => 'The selected company does not exist.',
            'specific_pitch_id.exists' => 'The selected pitch does not exist.',
            'specific_news_id.exists' => 'The selected news item does not exist.',
            'specific_preipo_transaction_id.exists'   => 'The selected transaction does not exist.',
        ]);
        if ($validation->fails()) {
            return redirect()->back()->withInput()
                ->with('error', 'Please check form errors.')->withErrors($validation);
        }
        $broadcastNotification = new BroadcastNotificationModel();
        $broadcastNotification->title = $request->title;
        $broadcastNotification->body = $request->body;
        $broadcastNotification->send_to = $request->send_to;

        if ($request->send_to === SendToUserTypeEnum::topic->value) {
            $broadcastNotification->topic = $request->topic;
        } else {
            $broadcastNotification->topic = null;
            $broadcastNotification->investors_ids = json_encode($request->selected_investors ?? []);
            $broadcastNotification->partners_ids = json_encode($request->selected_partners ?? []);
        }

        $data = [];

        if ($request->redirect_to) {
            $data['redirect_to'] = $request->redirect_to;

            // Add reference ID for specific startup/company
            if ($request->redirect_to === 'home/primary/startupdetail' && $request->specific_startup_id) {
                $data['reference_id'] = $request->specific_startup_id;
                $data['reference_type'] = 'startup';
            } elseif ($request->redirect_to === 'home/pre-ipo/companydetail' && $request->specific_company_id) {
                $data['reference_id'] = $request->specific_company_id;
                $data['reference_type'] = 'company';
            } elseif ($request->redirect_to === 'home/livepitch/detail' && $request->specific_pitch_id) {
                $data['reference_id'] = $request->specific_pitch_id;
                $data['reference_type'] = 'pitch';
            } elseif ($request->redirect_to === 'home/pre-ipo/news' && $request->specific_news_id) {
                $data['reference_id'] = $request->specific_news_id;
                $data['reference_type'] = 'preipo_news';
            } elseif ($request->redirect_to === 'home/pre-ipo/transactiondetail' && $request->specific_preipo_transaction_id) {
                $data['reference_id']   = $request->specific_preipo_transaction_id;
                $data['reference_type'] = 'preipo_transaction';
            }
        }

        // Store the complete data object
        $broadcastNotification->data = $data;

        if ($request->hasFile(key: 'image')) {
            $broadcastNotification->image = FileUpDownHelper::broadcast_push_notification_file_upload($request->file('image'));
        }
        $broadcastNotification->created_by = AdminHelper::getAdmin()->id;
        $broadcastNotification->updated_by = AdminHelper::getAdmin()->id;
        $broadcastNotification->save();
        AdminHelper::logPut('Broadcast created ' . $broadcastNotification->title, BroadcastNotificationModel::class, $broadcastNotification->id);

        // Whatsapp::dispatch($broadcast->id);
        PushNotificationJob::dispatch($broadcastNotification->id);
        return redirect()->route('admin.broadcast.pushNotification.list')->with('success', 'Broadcast Notification Created');
    }
}
