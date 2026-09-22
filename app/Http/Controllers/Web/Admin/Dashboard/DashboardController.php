<?php

namespace App\Http\Controllers\Web\Admin\Dashboard;

use App\Enums\PreIpoCategoryEnum;
use App\Enums\StartupPrimaryRoundStatusEnum;
use App\Helpers\AdminHelper;
use App\Helpers\FileUpDownHelper;
use App\Http\Controllers\Controller;
use App\Models\ApiLogModel;
use App\Models\CompanyDailySharePriceModel;
use App\Models\CompanyModel;
use App\Models\CompanySharePriceModel;
use App\Models\InvestorModel;
use App\Models\InvestorRegisterRequestModel;
use App\Models\PartnerModel;
use App\Models\PreIpoModel;
use App\Models\PrimaryTransactionModel;
use App\Models\SecondaryTransactionModel;
use App\Models\StartupModel;
use App\Models\UserAdminModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DashboardController extends Controller
{
    function index(): View
    {
        setPageTitle('Dashboard');
        addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);
        $currentMonthStart = Carbon::now()->startOfMonth();
        $currentMonthEnd = Carbon::now()->endOfMonth();

        $previousMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $previousMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        $current_month_total =
            PrimaryTransactionModel::whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])->whereHas('investor', fn($q) => $q->where('is_demo', '0'))->sum('investment_amount') +
            SecondaryTransactionModel::whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])->whereHas('investor', fn($q) => $q->where('is_demo', '0'))->sum('investment_amount') +
            PreIpoModel::whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])->where('status', '>=', 2)->where('is_valid', 1)->whereHas('investor', fn($q) => $q->where('is_demo', '0'))->sum('investment_amount');

        // Previous month total
        $previous_month_total =
            PrimaryTransactionModel::whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])->whereHas('investor', fn($q) => $q->where('is_demo', '0'))->sum('investment_amount') +
            SecondaryTransactionModel::whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])->whereHas('investor', fn($q) => $q->where('is_demo', '0'))->sum('investment_amount') +
            PreIpoModel::whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])->where('status', '>=', 2)->where('is_valid', 1)->whereHas('investor', fn($q) => $q->where('is_demo', '0'))->sum('investment_amount');
        // Calculate progress percentage (with safeguard against division by zero)
        if ($previous_month_total > 0) {
            $progress = (($current_month_total - $previous_month_total) / $previous_month_total) * 100;
        } else {
            $progress = 0;
        }

        // Format progress to integer or with decimals
        $progressFormatted = round($progress, 1); // e.g., 12.5%

        $today = Carbon::today();

        $managers = UserAdminModel::where('role', 'manager')
            ->where('is_deleted', '0')
            ->with([
                'investors' => function ($query) {
                    $query->where('is_demo', '0');
                },
                'investors.primaryTransactions' => function ($query) use ($currentMonthStart, $currentMonthEnd, $today) {
                    $query->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
                        ->orWhereDate('created_at', $today);
                },
                'investors.secondaryTransactions' => function ($query) use ($currentMonthStart, $currentMonthEnd, $today) {
                    $query->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
                        ->orWhereDate('created_at', $today);
                },
                'investors.perIpoTransactions' => function ($query) use ($currentMonthStart, $currentMonthEnd, $today) {
                    $query->where(function ($subQuery) use ($currentMonthStart, $currentMonthEnd, $today) {
                        $subQuery->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
                            ->orWhereDate('created_at', $today);
                    })->where('status', '>=', '2')->where('is_valid', 1);
                }
            ])
            ->get();

        $raisingNow = StartupModel::where('is_deleted', '0')
            ->where('registration_step', '6')
            ->whereHas('raising_round', function ($query) {
                $query->where('round_status', StartupPrimaryRoundStatusEnum::raisingnow);
            })
            ->with([
                'rounds' => function ($query) {
                    $query->where('round_status', StartupPrimaryRoundStatusEnum::raisingnow)
                        ->select('id', 'startup_id', 'round_status', 'fund_requirement');
                },
                'primary_transactions' => function ($query) {
                    $query->whereIn('round_id', function ($subQuery) {
                        $subQuery->select('id')
                            ->from('startup_round')
                            ->where('round_status', StartupPrimaryRoundStatusEnum::raisingnow);
                    })
                        ->whereHas('investor', function ($subQuery) {
                            $subQuery->where('is_demo', '0');
                        })
                        ->select(
                            'startup_id',
                            'round_id',
                            DB::raw('SUM(investment_amount) as total_investment')
                        )
                        ->groupBy('startup_id', 'round_id');
                }
            ])
            ->get()
            ->map(function ($startup) {
                $currentRound = $startup->rounds->first();

                $startup->fund_requirement = $currentRound ? $currentRound->fund_requirement : 0;

                $startup->investment_amount = $startup->primary_transactions
                    ->where('round_id', $currentRound->id)
                    ->first()
                    ?->total_investment ?? 0;

                $startup->percentage_completed = $startup->fund_requirement > 0
                    ? round(($startup->investment_amount / $startup->fund_requirement) * 100, 2)
                    : 0;

                return $startup;
            });

        // Calculate global totals from database (includes ALL investors, even without managers)
        $currentMonthPrimaryTotal = PrimaryTransactionModel::whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
            ->whereHas('investor', function ($query) {
                $query->where('is_demo', '0');
            })
            ->sum('investment_amount');

        $currentMonthSecondaryTotal = SecondaryTransactionModel::whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
            ->whereHas('investor', function ($query) {
                $query->where('is_demo', '0');
            })
            ->sum('investment_amount');

        $currentMonthPreIpoTotal = PreIpoModel::whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
            ->where('status', '>=', '2')
            ->where('is_valid', 1)
            ->whereHas('investor', function ($query) {
                $query->where('is_demo', '0');
            })
            ->sum('investment_amount');

        // Calculate today flags
        $primaryMadeToday = PrimaryTransactionModel::whereDate('created_at', Carbon::today())
            ->whereHas('investor', function ($query) {
                $query->where('is_demo', '0');
            })
            ->exists();

        $secondaryMadeToday = SecondaryTransactionModel::whereDate('created_at', Carbon::today())
            ->whereHas('investor', function ($query) {
                $query->where('is_demo', '0');
            })
            ->exists();

        $preIpoMadeToday = PreIpoModel::whereDate('created_at', Carbon::today())
            ->where('status', '>=', '2')
            ->where('is_valid', 1)
            ->whereHas('investor', function ($query) {
                $query->where('is_demo', '0');
            })
            ->exists();

        // Prepare manager data
        $managerData = $managers->map(function ($manager) use (
            $currentMonthStart,
            $currentMonthEnd,
            $today
        ) {
            $primaryTotal = 0;
            $secondaryTotal = 0;
            $preIpoTotal = 0;

            $investments = [];
            $preIpoInvestments = [];

            $managerMadeToday = false;

            // Process the transactions for each investor under the current manager
            foreach ($manager->investors as $investor) {
                // Primary Transactions
                foreach ($investor->primaryTransactions as $transaction) {
                    $transactionDate = Carbon::parse($transaction->created_at);
                    $investmentAmount = $transaction->investment_amount;

                    if ($transactionDate->isToday()) {
                        $managerMadeToday = true;
                    }

                    if ($transactionDate->between($currentMonthStart, $currentMonthEnd)) {
                        $primaryTotal += $investmentAmount;

                        $startup = $transaction->startup;
                        if ($startup) {
                            $investments[$startup->id] = $investments[$startup->id] ?? [
                                'name' => $startup->brand_name,
                                'logo' => FileUpDownHelper::get_startup_logo_url($startup),
                                'amount' => 0,
                                'made_today' => false
                            ];

                            $investments[$startup->id]['amount'] += $investmentAmount;

                            if ($transactionDate->isToday()) {
                                $investments[$startup->id]['made_today'] = true;
                            }
                        }
                    }
                }

                // Secondary Transactions
                foreach ($investor->secondaryTransactions as $transaction) {
                    $transactionDate = Carbon::parse($transaction->created_at);
                    $investmentAmount = $transaction->investment_amount;

                    if ($transactionDate->isToday()) {
                        $managerMadeToday = true;
                    }

                    if ($transactionDate->between($currentMonthStart, $currentMonthEnd)) {
                        $secondaryTotal += $investmentAmount;

                        $startup = $transaction->startup;
                        if ($startup) {
                            $investments[$startup->id] = $investments[$startup->id] ?? [
                                'name' => $startup->brand_name,
                                'logo' => FileUpDownHelper::get_startup_logo_url($startup),
                                'amount' => 0,
                                'made_today' => false
                            ];

                            $investments[$startup->id]['amount'] += $investmentAmount;

                            if ($transactionDate->isToday()) {
                                $investments[$startup->id]['made_today'] = true;
                            }
                        }
                    }
                }

                // Per-IPO Transactions
                foreach ($investor->perIpoTransactions as $transaction) {
                    $transactionDate = Carbon::parse($transaction->created_at);
                    $investmentAmount = $transaction->investment_amount;

                    if ($transactionDate->isToday()) {
                        $managerMadeToday = true;
                    }

                    if ($transactionDate->between($currentMonthStart, $currentMonthEnd)) {
                        $preIpoTotal += $investmentAmount;

                        $company = $transaction->company;
                        if ($company) {
                            $preIpoInvestments[$company->id] = $preIpoInvestments[$company->id] ?? [
                                'name' => $company->brand_name,
                                'logo' => FileUpDownHelper::get_company_logo_url($company),
                                'amount' => 0,
                                'made_today' => false
                            ];

                            $preIpoInvestments[$company->id]['amount'] += $investmentAmount;

                            if ($transactionDate->isToday()) {
                                $preIpoInvestments[$company->id]['made_today'] = true;
                            }
                        }
                    }
                }
            }

            // Merge investments and pre-IPO investments
            $common = array_merge(array_values($investments), array_values($preIpoInvestments));

            $totalInvestment = $primaryTotal + $secondaryTotal + $preIpoTotal;

            return [
                'name' => $manager->name,
                'profile_photo' => $manager->profile_photo,
                'investor_count' => $manager->investors->count(),
                'total_primary' => $primaryTotal,
                'total_secondary' => $secondaryTotal,
                'total_preipo' => $preIpoTotal,
                'total_investment' => $totalInvestment,
                'investments' => $common,
                'investment_made_today' => $managerMadeToday
            ];
        });

        // Calculate all-time totals in a single query to minimize database hits
        $allTimeTotalPrimary = PrimaryTransactionModel::whereHas('investor', function ($query) {
            $query->where('is_demo', '0');
        })->sum('investment_amount');

        $allTimeTotalSecondary = SecondaryTransactionModel::whereHas('investor', function ($query) {
            $query->where('is_demo', '0');
        })->sum('investment_amount');

        $allTimeTotalPreIpo = PreIpoModel::whereHas('investor', function ($query) {
            $query->where('is_demo', '0');
        })->where('status', '>=', '2')->where('is_valid', 1)
            ->sum('investment_amount');

        // Sort manager data by total investment (high to low)
        $sortedManagerData = $managerData->sortByDesc('total_investment')->values();

        // Calculate current month total across all categories
        $currentMonthTotal = $currentMonthPrimaryTotal + $currentMonthSecondaryTotal + $currentMonthPreIpoTotal;

        // Prepare the final data array
        $demoInvestorIds = InvestorModel::where('is_demo', '1')->pluck('id')->toArray();
        $demoPartnerIds = PartnerModel::where('is_demo', '1')->pluck('id')->toArray();

        $totalActiveInvestors = ApiLogModel::where('usertype', 'investor')->wherenotin('userid', $demoInvestorIds)
            ->distinct('userid')->where('userid', '!=', '0')
            ->count('userid');
        $totalActivePartners = ApiLogModel::wherein('usertype', ['wealthManager', 'distributor'])->wherenotin('userid', $demoPartnerIds)
            ->distinct('userid')->where('userid', '!=', '0')
            ->count('userid');

        $totalActiveInvestorsToday = ApiLogModel::where('usertype', 'investor')
            ->whereNotIn('userid', $demoInvestorIds)
            ->whereDate('created_at', Carbon::today())
            ->whereNotNull('userid')
            ->where('userid', '!=', '')
            ->where('userid', '!=', '0')
            ->distinct('userid')
            ->count('userid');
        $totalActivePartnersToday = ApiLogModel::whereIn('usertype', ['wealthManager', 'distributor'])
            ->whereNotIn('userid', $demoPartnerIds)
            ->whereDate('created_at', Carbon::today())
            ->whereNotNull('userid')
            ->where('userid', '!=', '')
            ->where('userid', '!=', '0')
            ->whereIn('userid', function ($query) {
                $query->select('id')
                    ->from('partner')
                    ->where('name', '!=', 'N/A');
            })
            ->distinct('userid')
            ->count('userid');
        $totalGuestInvestorsToday = ApiLogModel::where('url', 'like', '%investor%')
            ->where('userid', '0')->orwhere('userid', NULL)
            ->whereDate('created_at', Carbon::today())
            ->count();

        $totalInvestor = InvestorModel::where('is_deleted', '0')
            ->where('is_demo', '0')
            ->count();

        $totalPartner = PartnerModel::where('is_deleted', '0')
            ->where('is_demo', '0')
            ->count();

        $activeInvestorsTodayNames = [];
        if ($totalActiveInvestorsToday > 0) {
            $activeInvestorsTodayNames = ApiLogModel::where('usertype', 'investor')
                ->whereNotIn('userid', $demoInvestorIds)
                ->whereDate('created_at', Carbon::today())
                ->get()
                ->map(function ($log) {
                    return [
                        'name' => optional($log->user)->name,
                        'version_code' => $log->version_code,
                    ];
                })
                ->filter(fn($item) => !empty($item['name']))
                ->unique('name')
                ->take(18)
                ->values()
                ->all();
        }

        $activePartnersTodayNames = [];
        if ($totalActivePartnersToday > 0) {
            $partnerIds = ApiLogModel::whereIn('usertype', ['wealthManager', 'distributor'])
                ->whereNotIn('userid', $demoPartnerIds)
                ->whereDate('created_at', Carbon::today())
                ->distinct('userid')
                ->limit(18)
                ->pluck('userid')
                ->toArray();

            $activePartnersTodayNames = PartnerModel::whereIn('id', $partnerIds)
                ->pluck('name')
                ->toArray();
        }

        $recentRegisteredInvestorsCount = InvestorModel::where('is_deleted', 0)
            ->whereDate('created_at', '>', '2025-06-09')->where('created_by', NULL)
            ->count();


        $priceFluctuation = CompanyDailySharePriceModel::getPriceFluctuationAlert();

        // Set current year and month info
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        // Generate labels like "Jan 2025", "Feb 2025", etc.
        $months = collect(range(1, 12))->map(function ($m) use ($currentYear) {
            return Carbon::create($currentYear, $m, 1)->format('M Y');
        });

        // Aggregate monthly totals per investment type WITH year in label
        $primaryByMonth = PrimaryTransactionModel::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('SUM(investment_amount) as total')
        )
            ->whereYear('created_at', $currentYear)
            ->groupBy('month', 'year')
            ->pluck('total', 'month');

        $secondaryByMonth = SecondaryTransactionModel::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('SUM(investment_amount) as total')
        )
            ->whereYear('created_at', $currentYear)
            ->groupBy('month', 'year')
            ->pluck('total', 'month');

        $preipoByMonth = PreIpoModel::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('SUM(investment_amount) as total')
        )
            ->whereYear('created_at', $currentYear)
            ->where('status', '>=', 2)
            ->where('is_valid', 1)
            ->groupBy('month', 'year')
            ->pluck('total', 'month');

        // Prepare series with 0 for missing months
        $primarySeries = $months->map(function ($label, $i) use ($primaryByMonth) {
            return $primaryByMonth->get($i + 1, 0);
        })->toArray();

        $secondarySeries = $months->map(function ($label, $i) use ($secondaryByMonth) {
            return $secondaryByMonth->get($i + 1, 0);
        })->toArray();

        $preipoSeries = $months->map(function ($label, $i) use ($preipoByMonth) {
            return $preipoByMonth->get($i + 1, 0);
        })->toArray();

        // Current month total and previous month for growth
        $primaryThisMonth = $primaryByMonth->get($currentMonth, 0);
        $secondaryThisMonth = $secondaryByMonth->get($currentMonth, 0);
        $preipoThisMonth = $preipoByMonth->get($currentMonth, 0);
        $totalThisMonth = $primaryThisMonth + $secondaryThisMonth + $preipoThisMonth;

        // Growth calculation
        $prevMonth = $currentMonth - 1;
        $primaryPrevMonth = $primaryByMonth->get($prevMonth, 0);
        $secondaryPrevMonth = $secondaryByMonth->get($prevMonth, 0);
        $preipoPrevMonth = $preipoByMonth->get($prevMonth, 0);
        $totalPrevMonth = $primaryPrevMonth + $secondaryPrevMonth + $preipoPrevMonth;

        $growthPercent = 0;
        if ($totalPrevMonth > 0) {
            $growthPercent = (($totalThisMonth - $totalPrevMonth) / $totalPrevMonth) * 100;
        }

        // Final chart data structure for chart JS
        $chartData = [
            'labels' => $months->toArray(), // "Jan 2025", etc
            'series' => [
                [
                    'name' => 'Primary',
                    'data' => $primarySeries,
                ],
                [
                    'name' => 'Secondary',
                    'data' => $secondarySeries,
                ],
                [
                    'name' => 'Pre-IPO',
                    'data' => $preipoSeries,
                ],
            ],
            'totalThisMonth' => $totalThisMonth,
            'growth' => round($growthPercent, 1),
        ];
        // Companies price update status (oldest update = highest priority)
        $companiesPriceStatus = CompanySharePriceModel::select('company_id', DB::raw('MAX(date) as last_updated'))
            ->whereIn('company_id', function ($query) {
                $query->select('id')
                    ->from('company')
                    ->whereNotIn('category', [
                        PreIpoCategoryEnum::coming_soon->value,
                        PreIpoCategoryEnum::listed->value,
                    ])->where('is_deleted', '0');
            })
            ->groupBy('company_id')
            ->orderBy('last_updated', 'asc')
            ->get()
            ->map(function ($item) {
                $company = CompanyModel::find($item->company_id);
                if (!$company) return null;

                $daysSince = Carbon::parse($item->last_updated)->diffInDays(Carbon::today());

                return [
                    'company_id'   => $item->company_id,
                    'name'         => $company->brand_name,
                    'share_price'         => $company->share_price,
                    'logo'         => $company->logo,
                    'last_updated' => $item->last_updated,
                    'days_since'   => $daysSince,
                ];
            })
            ->filter()
            ->values();
        $data = [
            'company_Price_updated' => CompanyDailySharePriceModel::where('date', Carbon::today())->exists(),
            'active_user_total' => $totalActiveInvestors,
            'active_user_today' => $totalActiveInvestorsToday,
            'total_user' => $totalInvestor,
            'active_partner_total' => $totalActivePartners,
            'active_partner_today' => $totalActivePartnersToday,
            'total_partner' => $totalPartner,
            'active_guest_total' => $totalGuestInvestorsToday,
            'request_access' => InvestorRegisterRequestModel::where('is_readed', '0')->count(),
            'request_access_all' => InvestorRegisterRequestModel::count(),
            'request_access_converted' => InvestorRegisterRequestModel::where('is_converted', '1')->count(),
            'request_access_today' => InvestorRegisterRequestModel::WhereDate('created_at', Carbon::today())->exists(),
            'pre_request_access' => PreIpoModel::where('status', '0')
                ->whereHas('investor', function ($query) {
                    $query->where('is_demo', '0');
                })->count(),
            'pre_request_access_all' => PreIpoModel::whereHas('investor', function ($query) {
                $query->where('is_demo', '0');
            })->where('is_valid', 1)->count(),
            'pre_request_access_today' => PreIpoModel::whereHas('investor', function ($query) {
                $query->where('is_demo', '0');
            })->whereDate('created_at', Carbon::today())->where('is_valid', 1)->exists(),
            'pre_request_access_older' => PreIpoModel::where('status', '0')
                ->whereHas('investor', function ($query) {
                    $query->where('is_demo', '0');
                })->whereDate('created_at', '<', Carbon::today())->where('is_valid', 1)->count(),
            'manager_list' => $sortedManagerData,
            'current_month_total' => $currentMonthTotal,
            'progress' => $progressFormatted,
            'primary_total' => $allTimeTotalPrimary,
            'secondary_total' => $allTimeTotalSecondary,
            'preipo_total' => $allTimeTotalPreIpo,
            'primary_made_today' => $primaryMadeToday,
            'secondary_made_today' => $secondaryMadeToday,
            'preipo_made_today' => $preIpoMadeToday,
            'total_amount' => $allTimeTotalPrimary + $allTimeTotalSecondary + $allTimeTotalPreIpo,
            'flag_for_today' => ($primaryMadeToday || $secondaryMadeToday || $preIpoMadeToday),
            'raising_now_startups' => $raisingNow,
            'active_investors_today_names' => $activeInvestorsTodayNames,
            'active_partners_today_names' => $activePartnersTodayNames,
            'recent_registered_investors' => $recentRegisteredInvestorsCount,
            'price_fluctuation' => $priceFluctuation,
            'companies_price_status' => $companiesPriceStatus,
        ];
        $data['chartData'] = $chartData;
        return view('admin.pages.dashboards.index', $data);
    }
    // Show Pre-IPO transactions for a given investor name
    // Show Pre‑IPO transactions performed in the current month (includes investor name)
    public function preIpoInvestor(): View
    {
        $transactions = PreIpoModel::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->where('status', '>=', 2)
            ->where('is_valid', 1)
            ->with(['company', 'investor'])
            ->get();

        return view('admin.pages.dashboards.preipo_investor', [
            'transactions' => $transactions,
        ]);
    }
}
