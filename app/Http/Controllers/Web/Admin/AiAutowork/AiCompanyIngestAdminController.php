<?php

namespace App\Http\Controllers\Web\Admin\AiAutowork;

use App\Enums\TempCompanyStatusEnum;
use App\Helpers\AdminHelper;
use App\Http\Controllers\Controller;
use App\Models\MasterSectorsModel;
use App\Models\TempCompanyModel;
use App\Services\AiAutowork\PromoteTempCompanyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AiCompanyIngestAdminController extends Controller
{
    public function __construct(private PromoteTempCompanyService $promoteService)
    {
    }

    public function inbox(Request $request): View
    {
        setPageTitle('AI Company Ingest Inbox');
        $status = $request->get('status', 'pending');
        $query = TempCompanyModel::with(['matchedCompany:id,brand_name', 'sector:id,name'])
            ->orderByDesc('id');

        if (in_array($status, ['pending', 'rejected', 'approved'], true)) {
            $query->where('status', $status);
        } else {
            $status = 'all';
        }

        $data['list'] = $query->paginate(20)->withQueryString();
        $data['status'] = $status;
        $data['pendingCount'] = TempCompanyModel::where('status', TempCompanyStatusEnum::pending)->count();

        return view('admin.pages.ai-autowork.company-ingest.inbox', $data);
    }

    public function review(string $uuid): RedirectResponse|View
    {
        $item = TempCompanyModel::where('uuid', $uuid)->first();
        if (!$item) {
            return redirect()->route('admin.ai-autowork.company-ingest.inbox')
                ->with('error', 'Record not found');
        }

        setPageTitle('Review AI Company: ' . ($item->brand_name ?: $item->cin ?: $item->uuid));
        $data['item'] = $item;
        $data['sectors'] = MasterSectorsModel::where('is_deleted', 0)->orderBy('name')->get();

        return view('admin.pages.ai-autowork.company-ingest.review', $data);
    }

    public function update(Request $request, string $uuid): RedirectResponse
    {
        $item = TempCompanyModel::where('uuid', $uuid)->first();
        if (!$item) {
            return redirect()->route('admin.ai-autowork.company-ingest.inbox')
                ->with('error', 'Record not found');
        }

        if ($item->status->value !== 'pending') {
            return redirect()->back()->with('error', 'Only pending records can be edited.');
        }

        $this->applyReviewPayload($request, $item);
        $item->save();

        return redirect()->route('admin.ai-autowork.company-ingest.review', $item->uuid)
            ->with('success', 'Temp company saved (not promoted to master yet).');
    }

    public function approve(Request $request, string $uuid): RedirectResponse
    {
        $item = TempCompanyModel::where('uuid', $uuid)->first();
        if (!$item) {
            return redirect()->route('admin.ai-autowork.company-ingest.inbox')
                ->with('error', 'Record not found');
        }

        if ($item->status->value !== 'pending') {
            return redirect()->back()->with('error', 'Only pending records can be approved.');
        }

        // Persist the review form first (Approve posts the same fields).
        $this->applyReviewPayload($request, $item);
        $item->save();
        $item->refresh();

        $replace = [
            'promoters' => $request->boolean('replace_promoters'),
            'shareholders' => $request->boolean('replace_shareholders'),
            'events' => $request->boolean('replace_events'),
            'financials' => $request->boolean('replace_financials'),
        ];

        try {
            $adminId = Auth::guard('admin')->id();
            $company = $this->promoteService->approve($item, (int) $adminId, $replace);

            return redirect()->route('admin.company.edit', $company->uuid)
                ->with('success', 'Approved and promoted to master company.');
        } catch (ValidationException $e) {
            return redirect()
                ->route('admin.ai-autowork.company-ingest.review', $item->uuid)
                ->withInput()
                ->withErrors($e->errors())
                ->with('error', 'Cannot approve: fill required fields first. Your entered values were kept — fix the highlighted fields and try again.');
        } catch (\Throwable $e) {
            return redirect()
                ->route('admin.ai-autowork.company-ingest.review', $item->uuid)
                ->withInput()
                ->with('error', 'Approve failed: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, string $uuid): RedirectResponse
    {
        $item = TempCompanyModel::where('uuid', $uuid)->first();
        if (!$item) {
            return redirect()->route('admin.ai-autowork.company-ingest.inbox')
                ->with('error', 'Record not found');
        }

        try {
            $adminId = Auth::guard('admin')->id();
            $this->promoteService->reject($item, (int) $adminId, $request->input('admin_notes'));

            return redirect()->route('admin.ai-autowork.company-ingest.inbox', ['status' => 'rejected'])
                ->with('success', 'Rejected.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->with('error', 'Cannot reject.');
        }
    }

    public function reopen(string $uuid): RedirectResponse
    {
        $item = TempCompanyModel::where('uuid', $uuid)->first();
        if (!$item) {
            return redirect()->route('admin.ai-autowork.company-ingest.inbox')
                ->with('error', 'Record not found');
        }

        $status = $item->status->value ?? (string) $item->status;
        if (!in_array($status, ['approved', 'rejected'], true)) {
            return redirect()->back()->with('error', 'Only approved or rejected records can be reopened.');
        }

        // Keep matched company so re-approve updates live data when CIN still matches.
        if ($item->cin) {
            $matched = \App\Models\CompanyModel::where('is_deleted', 0)
                ->whereRaw('UPPER(REPLACE(cin, " ", "")) = ?', [$item->cin])
                ->first();
            $item->matched_company_id = $matched?->id ?? $item->matched_company_id;
            $item->intent = $item->matched_company_id
                ? \App\Enums\TempCompanyIntentEnum::update
                : \App\Enums\TempCompanyIntentEnum::create;
        }

        $item->status = TempCompanyStatusEnum::pending;
        $item->reviewed_by = null;
        $item->reviewed_at = null;
        $item->save();

        AdminHelper::logPut('AI AutoWork company reopened to pending', TempCompanyModel::class, $item->id);

        return redirect()->route('admin.ai-autowork.company-ingest.review', $item->uuid)
            ->with('success', 'Reopened as pending — you can edit and approve again.');
    }

    public function destroy(string $uuid): RedirectResponse
    {
        $item = TempCompanyModel::where('uuid', $uuid)->first();
        if (!$item) {
            return redirect()->route('admin.ai-autowork.company-ingest.inbox')
                ->with('error', 'Record not found');
        }

        $id = $item->id;
        $status = $item->status->value ?? (string) $item->status;
        $item->delete();

        AdminHelper::logPut('AI AutoWork company ingest deleted (' . $status . ')', TempCompanyModel::class, $id);

        return redirect()->route('admin.ai-autowork.company-ingest.inbox')
            ->with('success', 'Ingest record deleted.');
    }

    public function guide(): View
    {
        setPageTitle('AI Guide — Company Ingest');

        $data['apiBase'] = rtrim(url('/api/sandbox/ai'), '/');
        $data['schemaUrl'] = url('/api/sandbox/ai/schema');
        $data['companiesUrl'] = url('/api/sandbox/ai/companies');

        return view('admin.pages.ai-autowork.company-ingest.guide', $data);
    }

    private function applyReviewPayload(Request $request, TempCompanyModel $item): void
    {
        $item->cin = TempCompanyModel::normalizeCin($request->input('cin'));
        $item->brand_name = $request->input('brand_name');
        $item->company_name = $request->input('company_name');
        $item->about = $request->input('about');
        $item->keywords = $request->input('keywords');
        $item->negative_keywords = $request->input('negative_keywords');
        $item->alternative_names = $request->input('alternative_names');
        $item->type = $request->input('type');
        $item->is_drhp = $request->boolean('is_drhp');
        $item->sector_id = $request->input('sector_id') ?: null;
        if ($item->sector_id) {
            $sector = MasterSectorsModel::find($item->sector_id);
            $item->sector_name = $sector?->name;
        }
        $item->min_investment_amount = $request->input('min_investment_amount');
        $item->commission = $request->input('commission');
        $item->processing_fee_percentage = $request->input('processing_fee_percentage');
        if ($request->filled('admin_notes')) {
            $item->admin_notes = $request->input('admin_notes');
        }
        $item->logo_url = $request->input('logo_url');

        if ($request->hasFile('logo')) {
            $uploaded = \App\Helpers\FileUpDownHelper::company_logo_upload($request->file('logo'));
            if ($uploaded) {
                $item->logo = $uploaded;
            }
        } elseif ($request->filled('logo_url') && !$item->logo) {
            $downloaded = app(\App\Services\AiAutowork\AiCompanyIngestService::class)
                ->downloadLogoPublic((string) $request->input('logo_url'));
            if ($downloaded) {
                $item->logo = $downloaded;
            }
        }

        if ($request->has('fundamentals')) {
            $item->fundamentals = $this->normalizeFundamentals($request->input('fundamentals'));
        }
        if ($request->has('promoters')) {
            $item->promoters = $this->normalizePromoters($request->input('promoters'));
        }
        if ($request->has('shareholders')) {
            $item->shareholders = app(\App\Services\AiAutowork\AiCompanyIngestService::class)
                ->normalizeShareholders($request->input('shareholders'));
        }
        if ($request->has('events')) {
            $item->events = $this->normalizeEvents($request->input('events'));
        }

        $matched = null;
        if ($item->cin) {
            $matched = \App\Models\CompanyModel::where('is_deleted', 0)
                ->whereRaw('UPPER(REPLACE(cin, " ", "")) = ?', [$item->cin])
                ->first();
        }
        $item->matched_company_id = $matched?->id;
        $item->intent = $matched
            ? \App\Enums\TempCompanyIntentEnum::update
            : \App\Enums\TempCompanyIntentEnum::create;
    }

    private function normalizeFundamentals(mixed $input): ?array
    {
        if (!is_array($input)) {
            return null;
        }

        $out = [];
        foreach ($input as $key => $value) {
            if ($value === null || $value === '') {
                continue;
            }
            $out[$key] = $value;
        }

        return $out === [] ? null : $out;
    }

    private function normalizePromoters(mixed $input): ?array
    {
        if (!is_array($input)) {
            return null;
        }

        $rows = [];
        foreach ($input as $row) {
            if (!is_array($row)) {
                continue;
            }
            $name = $row['name'] ?? null;
            $designation = $row['designation'] ?? $row['role'] ?? null;
            $experience = $row['experience'] ?? $row['bio'] ?? null;
            $url = $row['url'] ?? $row['linkedin'] ?? $row['linkedin_url'] ?? null;
            if (empty($name) && empty($designation) && empty($experience) && empty($url)) {
                continue;
            }
            $rows[] = [
                'name' => $name,
                'designation' => $designation,
                'experience' => $experience,
                'url' => $url,
            ];
        }

        return $rows === [] ? null : $rows;
    }

    private function normalizeEvents(mixed $input): ?array
    {
        if (!is_array($input)) {
            return null;
        }

        $rows = [];
        foreach ($input as $row) {
            if (!is_array($row)) {
                continue;
            }
            if (empty($row['title']) && empty($row['description']) && empty($row['date']) && empty($row['file'])) {
                continue;
            }
            $rows[] = [
                'title' => $row['title'] ?? null,
                'description' => $row['description'] ?? null,
                'date' => $row['date'] ?? null,
                'file' => $row['file'] ?? null,
            ];
        }

        usort($rows, function ($a, $b) {
            $da = strtotime((string) ($a['date'] ?? '')) ?: 0;
            $db = strtotime((string) ($b['date'] ?? '')) ?: 0;

            return $db <=> $da;
        });

        return $rows === [] ? null : array_slice($rows, 0, 5);
    }
}