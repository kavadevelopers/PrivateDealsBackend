<?php

namespace App\Exports;

use App\Models\ApiLogModel;
use App\Models\InvestorModel;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class InvestorExport implements FromView
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $query = InvestorModel::with('partner', 'kyc')
            ->where('is_deleted', 0);

        if ($this->request->filled('demo_filter')) {
            $query->where('is_demo', $this->request->demo_filter);
        }

        if ($this->request->filled('partner')) {
            $this->request->partner === 'with'
                ? $query->whereNotNull('partner_id')
                : $query->whereNull('partner_id');
        }

        if ($this->request->filled('kyc')) {
            $this->request->kyc === 'with'
                ? $query->whereHas('kyc')
                : $query->doesntHave('kyc');
        }

        if ($this->request->filled('access')) {
            match ($this->request->access) {
                'primary'   => $query->where('is_primary_access', 1),
                'secondary' => $query->where('is_secondary_access', 1),
                'preipo'    => $query->where('is_preipo_access', 1),
                default     => null
            };
        }

        if ($this->request->date_filter == 'after_june_9') {
            $query->whereDate('created_at', '>', '2025-06-09')
                ->where('created_by', NULL);
        } elseif ($this->request->date_filter == 'before_june_9') {
            $query->where(function ($q) {
                $q->whereDate('created_at', '<=', '2025-06-09')
                    ->orWhereNotNull('created_by');
            });
        }

        // Apply startup filter
        if ($this->request->filled('startup_filter')) {
            $query->whereHas('primaryTransactions', function ($q) {
                $q->where('startup_id', $this->request->startup_filter)
                    ->where('status', '10'); // Assuming 10 means completed
            });
        }

        // Apply pre-IPO company filter
        if ($this->request->filled('preipo_filter')) {
            $query->whereHas('perIpoTransactions', function ($q) {
                $q->where('company_id', $this->request->preipo_filter)
                    ->where('status', '5'); // Assuming 5 means completed
            });
        }

        if ($this->request->filled('active_filter')) {
            $demoInvestorIds = InvestorModel::where('is_demo', 1)->pluck('id')->toArray();

            $activeUserIdsQuery = ApiLogModel::where('usertype', 'investor')
                ->whereNotIn('userid', $demoInvestorIds)
                ->whereNotNull('userid')
                ->where('userid', '!=', '0');

            if ($this->request->active_filter === 'today') {
                $activeUserIds = $activeUserIdsQuery
                    ->whereDate('created_at', Carbon::today())
                    ->distinct()
                    ->pluck('userid')
                    ->toArray();

                $query->whereIn('id', $activeUserIds);
            } elseif ($this->request->active_filter === 'overall') {
                $activeUserIds = $activeUserIdsQuery
                    ->distinct()
                    ->pluck('userid')
                    ->toArray();

                $query->whereIn('id', $activeUserIds);
            } elseif ($this->request->active_filter === 'inactive') {
                $activeUserIds = $activeUserIdsQuery
                    ->distinct()
                    ->pluck('userid')
                    ->toArray();

                $query->whereNotIn('id', $activeUserIds);
            }
        }


        $investors = $query->get();

        return view('admin.pages.investor.export-excel', [
            'investors' => $investors,
            'filters' => [
                'partner' => $this->request->partner,
                'kyc' => $this->request->kyc,
                'access' => $this->request->access,
                'date_filter' => $this->request->date_filter,
                'startup_filter' => $this->request->startup_filter,
                'preipo_filter' => $this->request->preipo_filter,
                'active_filter' => $this->request->active_filter
            ]
        ]);
    }
}
