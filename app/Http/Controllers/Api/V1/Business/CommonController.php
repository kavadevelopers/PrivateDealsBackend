<?php

namespace App\Http\Controllers\Api\V1\Business;

use App\Enums\DocumentTypeEnum;
use App\Enums\GenderEnum;
use App\Enums\InstrumentTypeEnum;
use App\Enums\InvestorTypeEnum;
use App\Enums\NotificationTypeEnum;
use App\Enums\PartnerTypeEnum;
use App\Enums\WpMessageTypeEnum;
use App\Helpers\CommonHelper;
use App\Helpers\DateTimeHelper;
use App\Helpers\PreIpoTransactionHelper;
use App\Helpers\PrimaryTransactionHelper;
use App\Helpers\SecondaryTransactionHelper;
use App\Helpers\UtillsHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\InvestorRequest;
use App\Jobs\broadcast\Whatsapp;
use App\Models\InvestorModel;
use App\Models\MasterCityModel;
use App\Models\PartnerModel;
use App\Models\PortfolioModel;
use App\Models\PortfolioPreIpoModel;
use App\Models\PreIpoModel;
use App\Models\PreIpoSellRequestModel;
use App\Models\PrimaryTransactionModel;
use App\Models\SecondarySellRequestModel;
use App\Models\SecondaryTransactionModel;
use App\Models\StartupModel;
use App\Repositories\InvestorRepository;
use App\Repositories\PartnerRepository;
use App\Traits\FirebaseTrait;
use App\Traits\PMailerTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\JsonResponse;

class CommonController extends Controller
{
    use FirebaseTrait, PMailerTrait;
    private $partnerRepo;
    private $invRepo;

    function __construct(PartnerRepository $partnerRepository, InvestorRepository $investorRepository)
    {
        $this->partnerRepo = $partnerRepository;
        $this->invRepo = $investorRepository;
    }

    function getPortfolio(): JsonResponse
    {
        $request = request();
        $investor_ids = InvestorModel::where('partner_id', $request->user()->id)->where('is_deleted', 0)->pluck('id')->toArray();

        if ($request->has('investor_ids') && !empty($request->investor_ids)) {
            $requested_ids = explode(',', $request->investor_ids);
            $requested_ids = array_map('trim', $requested_ids);
            $investor_ids = array_intersect($requested_ids, $investor_ids);
        }
        $portfolio = PortfolioModel::whereIn('investor_id', $investor_ids)->with('startup.details', 'startup.cms', 'investor')->where('shares', '>', '0');

        if ($request->has('startup_ids') && !empty($request->startup_ids)) {
            $startup_ids = explode(',', $request->startup_ids);
            $startup_ids = array_map('trim', $startup_ids);
            $portfolio->whereIn('startup_id', $startup_ids);
        }

        if (!$portfolio->exists()) {
            return UtillsHelper::json(1, ['message' => 'No portfolio found for the given criteria']);
        }

        // $data = null;

        if ($request->has('type')) {
            switch ($request->type) {
                case InstrumentTypeEnum::equity->value:
                    $data = (clone $portfolio)->where('instrument', InstrumentTypeEnum::equity);
                    break;
                case InstrumentTypeEnum::ccps->value:
                    $data = (clone $portfolio)->where('instrument', InstrumentTypeEnum::ccps);
                    break;
                case InstrumentTypeEnum::ccd->value:
                    $data = (clone $portfolio)->where('instrument', InstrumentTypeEnum::ccd);
                    break;
                default:
                    break;
            }
        } else {
            return UtillsHelper::json(0, ['message' => 'Type Required']);
        }
        $data = $data->get();

        return UtillsHelper::json(
            1,
            [
                'message'   => "Portfolio List",
                'data'      => $data,
            ],
            200
        );
    }

    function getPortfolioDetails(): JsonResponse
    {
        $request = request();

        $validation = Validator::make($request->all(), [
            'portfolio_id' => 'required',
        ]);

        if ($validation->fails()) {
            return UtillsHelper::json(
                0,
                [
                    'message' => $validation->errors()->first()
                ],
                200
            );
        }

        // Get all investor_ids under this partner
        $investorIds = InvestorModel::where('partner_id', $request->user()->id)
            ->where('is_deleted', 0)
            ->pluck('id')
            ->toArray();

        // Fetch the portfolio only if it belongs to the partner's investors
        $portfolio = PortfolioModel::with('startup.cms', 'investor')
            ->where('id', $request->portfolio_id)
            ->whereIn('investor_id', $investorIds)
            ->first();

        if (!$portfolio) {
            return UtillsHelper::json(0, ['message' => 'Portfolio not found or does not belong to your investors.']);
        }

        // Fetch associated transactions
        $portfolio->primary_transactions = PrimaryTransactionModel::where('portfolio_id', $portfolio->id)->get();
        $portfolio->secondary_transactions = SecondaryTransactionModel::where('c_portfolio_id', $portfolio->id)->get();

        return UtillsHelper::json(
            1,
            [
                'message' => 'Portfolio details fetched successfully',
                'data' => $portfolio,
            ],
            200
        );
    }


    function portfolioPreIpo(): JsonResponse
    {
        $request = request();
        $investor_ids = InvestorModel::where('partner_id', $request->user()->id)->where('is_deleted', 0)->pluck('id')->toArray();
        if ($request->has('investor_ids')) {
            $requested_ids = explode(',', $request->investor_ids); // Convert comma-separated string to array
            $requested_ids = array_map('trim', $requested_ids); // Trim spaces from each value
            $investor_ids = array_intersect($requested_ids, $investor_ids); // Keep only valid investor IDs
        }
        $portfolio = PortfolioPreIpoModel::whereIn('investor_id', $investor_ids)
            ->with([
                'company' => function ($query) {
                    $query->select('id', 'brand_name', 'logo');
                }
            ])->with('investor')
            ->where('shares', '>', '0')
            ->get()
            ->map(function ($transaction) {
                $transaction->company->makeHidden(['transaction', 'share_price', 'distributer_price', 'share_prices', 'base_price']); // Optional: Hide other attributes if required
                return $transaction;
            });
        return UtillsHelper::json(
            1,
            [
                'message'   => "Portfolio List",
                'data'      => $portfolio
            ],
            200
        );
    }

    function getPortfolioPreIpoDetail(): JsonResponse
    {
        $request = request();

        $validation = Validator::make($request->all(), [
            'portfolio_id'  => 'required',
        ]);

        if ($validation->fails()) {
            return UtillsHelper::json(
                0,
                [
                    'message' => $validation->errors()->first()
                ],
                200
            );
        }

        // Get all investor_ids under this partner
        $investorIds = InvestorModel::where('partner_id', $request->user()->id)
            ->where('is_deleted', 0)
            ->pluck('id')
            ->toArray();

        // Fetch the portfolio only if it belongs to one of the partner's investors
        $portfolio = PortfolioPreIpoModel::with([
            'company' => function ($query) {
                $query->select('id', 'brand_name', 'logo');
            }
        ])
            ->where('id', $request->portfolio_id)
            ->whereIn('investor_id', $investorIds)
            ->first();

        if (!$portfolio) {
            return UtillsHelper::json(0, ['message' => 'Portfolio not found or does not belong to your investors.']);
        }

        $portfolio->company->makeHidden(['transaction', 'share_price', 'distributer_price', 'base_price']);
        $portfolio->transactions = PreIpoModel::where('portfolio_id', $portfolio->id)->get();

        return UtillsHelper::json(
            1,
            [
                'message' => 'Portfolio details fetched successfully',
                'data' => $portfolio,
            ],
            200
        );
    }



    function getStartupLiteNew(): JsonResponse
    {
        $request = request();

        $investorIds = InvestorModel::where('partner_id', $request->user()->id)
            ->where('is_deleted', 0)
            ->pluck('id')
            ->toArray();

        if (empty($investorIds)) {
            return UtillsHelper::json(1, ['message' => 'No investors found for this wealth manager', 'data' => []]);
        }

        $startups = StartupModel::whereHas('portfolio', function ($query) use ($investorIds) {
            $query->whereIn('investor_id', $investorIds);
        })->select('id', 'brand_name')->get();

        return UtillsHelper::json(1, ['message' => 'Filtered Startup List', 'data' => $startups]);
    }
    function preIpoTransaction(): JsonResponse
    {
        $request = request();
        $transactions = PreIpoModel::whereHas('investor', function ($query) use ($request) {
            $query->where('partner_id', $request->user()->id);
        })->with('company')
            ->orderby('id', 'desc')
            ->get()
            ->map(function ($transaction) {
                $transaction->company->makeHidden(['transaction']);
                return $transaction;
            });

        return UtillsHelper::json(1, [
            'message' => 'Transaction List',
            'data' => $transactions
        ], 200);
    }

    function preIpoTransactionsDetails(): JsonResponse
    {
        $request = request();

        $validation = Validator::make($request->all(), [
            'transaction_id' => 'required',
        ]);

        if ($validation->fails()) {
            return UtillsHelper::json(
                0,
                [
                    'message' => $validation->errors()->first()
                ],
                200
            );
        }

        $transaction = PreIpoModel::with('company', 'investor')
            ->where('id', $request->transaction_id)
            ->whereHas('investor', function ($query) use ($request) {
                $query->where('partner_id', $request->user()->id);
            })
            ->first();

        if (!$transaction) {
            return UtillsHelper::json(0, ['message' => 'Transaction not found or does not belong to the partner.']);
        }

        $transaction->company->makeHidden(['transaction']);
        $transaction->status_list = PreIpoTransactionHelper::getStatusListForApplication($transaction);

        return UtillsHelper::json(1, [
            'message' => 'Transaction details fetched successfully',
            'data' => $transaction
        ]);
    }

    function preIpoSellTransactions(): JsonResponse
    {
        $request = request();
        $transactions = PreIpoSellRequestModel::whereHas('investor', function ($query) use ($request) {
            $query->where('partner_id', $request->user()->id);
        })->with([
            'company' => function ($query) {
                $query->select('id', 'brand_name', 'logo');
            }
        ])
            ->orderby('id', 'desc')
            ->get()->map(function ($transaction) {
                $transaction->company->makeHidden(['transaction', 'share_price', 'distributer_price', 'base_price']);
                return $transaction;
            });
        return UtillsHelper::json(1, [
            'message' => 'Transaction List',
            'data' => $transactions
        ], 200);
    }

    function secTransaction(): JsonResponse
    {
        $request = request();
        $distributer = PartnerModel::where('id', $request->user()->id)->with('investor')->first();

        $list = [];

        // Get transactions from all investors associated with the distributer
        foreach ($distributer->investor as $investor) {
            // Fetch sell requests for each investor
            $sellRequests = SecondarySellRequestModel::where('investor_id', $investor->id)
                ->with('startup.details', 'startup.cms')
                ->with(['transactions' => function ($query) {
                    $query->whereNotIn('status', [2, 3])->with('buyer');
                }])
                ->orderby('id', 'desc')
                ->get();

            foreach ($sellRequests as $sellRequest) {
                $list[] = [
                    'type' => 'sell',
                    'sell' => $sellRequest,
                    'buy' => NULL,
                    'created_at' => $sellRequest->created_at,
                ];
            }

            // Fetch buy transactions for each investor
            $transactions = SecondaryTransactionModel::where('buyer_id', $investor->id)
                ->with('startup.details', 'startup.cms', 'escrow')
                ->get();

            foreach ($transactions as $transaction) {
                $list[] = [
                    'type' => 'buy',
                    'sell' => NULL,
                    'buy' => $transaction,
                    'created_at' => $transaction->created_at,
                ];
            }
        }

        // Sort by creation date, descending
        usort($list, function ($a, $b) {
            return $b['created_at'] <=> $a['created_at'];
        });

        return UtillsHelper::json(1, [
            'message' => 'Distributer Transaction List',
            'data' => $list
        ], 200);
    }

    public function secTransactionDetails(): JsonResponse
    {
        $request = request();

        $validation = Validator::make($request->all(), [
            'transaction_id'  => 'nullable',
            'sell_request_id' => 'nullable',
        ]);

        $validation->after(function ($validator) use ($request) {
            $hasTransactionId = $request->filled('transaction_id');
            $hasSellRequestId = $request->filled('sell_request_id');

            if (!$hasTransactionId && !$hasSellRequestId) {
                $validator->errors()->add('transaction_id', 'One of transaction_id or sell_request_id is required.');
            }

            if ($hasTransactionId && $hasSellRequestId) {
                $validator->errors()->add('transaction_id', 'Only one of transaction_id or sell_request_id should be provided.');
            }
        });

        if ($validation->fails()) {
            return UtillsHelper::json(
                0,
                [
                    'message' => $validation->errors()->first()
                ],
                200
            );
        }

        if ($request->has('transaction_id')) {
            $transaction = SecondaryTransactionModel::with('startup.cms', 'seller')
                ->where('id', $request->transaction_id)
                ->whereHas('buyer', function ($query) use ($request) {
                    $query->where('partner_id', $request->user()->id);
                })
                ->first();

            if (!$transaction) {
                return UtillsHelper::json(0, ['message' => 'Transaction not found or does not belong to the partner.']);
            }

            $transaction->status_list = SecondaryTransactionHelper::getTransactionStatusListForApplication($transaction);

            $data = [
                'type' => 'buy',
                'sell' => NULL,
                'buy' => $transaction,
                'created_at' => $transaction->created_at,
            ];

            return UtillsHelper::json(1, ['message' => 'Detail', 'data' => $data]);
        } else {
            $sellRequest = SecondarySellRequestModel::with('startup.cms', 'transactions.buyer')
                ->where('id', $request->sell_request_id)
                ->whereHas('investor', function ($query) use ($request) {
                    $query->where('partner_id', $request->user()->id);
                })
                ->first();

            if (!$sellRequest) {
                return UtillsHelper::json(0, ['message' => 'Sell request not found or does not belong to the partner.']);
            }

            if ($sellRequest->transactions && $sellRequest->transactions->count()) {
                foreach ($sellRequest->transactions as $trans) {
                    $trans->status_list = SecondaryTransactionHelper::getTransactionStatusListForApplication($trans);
                }
            }

            $sellRequest->status_list = SecondaryTransactionHelper::getSellRequestStatusListForApplication($sellRequest);

            $data = [
                'type' => 'sell',
                'sell' => $sellRequest,
                'buy' => NULL,
                'created_at' => $sellRequest->created_at,
            ];

            return UtillsHelper::json(1, ['message' => 'Detail', 'data' => $data]);
        }
    }


    function sendDocument(): JsonResponse
    {
        $request = request();
        $validation = Validator::make($request->all(), [
            'transaction_id' => 'required',
            'document_type' => ['required', Rule::enum(DocumentTypeEnum::class)],
        ]);
        if ($validation->fails()) {
            return UtillsHelper::json(0, ['message' => $validation->errors()->first()]);
        }
        $transaction = PrimaryTransactionModel::find($request->transaction_id);
        if (!$transaction) {
            return UtillsHelper::json(0, ['message' => 'Transaction not found'], 200);
        }
        // Get document type from request and call the corresponding attribute
        // $docType = $request->document_type;

        // $document = match ($docType) {
        //     DocumentTypeEnum::ssa->value => $transaction->ssa_document,
        //     DocumentTypeEnum::mgtchallan->value => $transaction->mgt_challan_document,
        //     DocumentTypeEnum::pas->value => $transaction->pas_zip_document,
        //     DocumentTypeEnum::mgtzip->value => $transaction->mgt_zip_document,
        //     DocumentTypeEnum::offer->value => $transaction->offer_document,
        //     DocumentTypeEnum::chequecounterslip->value => $transaction->counter_slip,
        //     DocumentTypeEnum::rtgsreceipt->value => $transaction->rtgs_receipt,
        //     DocumentTypeEnum::sha->value => $transaction->sha_document,
        //     DocumentTypeEnum::loi->value => $transaction->loi_document,
        //     default => null,
        // };

        // if (!$document && $document->status != 1) {
        //     return UtillsHelper::json(0, ['message' => 'Document not found'], 200);
        // }
        // $documentUrl = $this->fileUrl($document->signed_path);

        // UtillsHelper::sendWpMessage(
        //     NotificationTypeEnum::regular,
        //     'shuruup_document_sending',
        //     WpMessageTypeEnum::media,
        //     $transaction->investor->mobile_number,
        //     $transaction->investor->name,
        //     $documentUrl,
        //     [],
        //     [$transaction->investor->name, $document->type],
        //     ['partner_id' => $request->user()->id, 'transaction_id' => $transaction->id, 'document_type' => $docType],
        //     NULL,
        //     true
        // );
        // if (!empty($transaction->investor->email)) {
        //     $this->sendMail(
        //         NotificationTypeEnum::regular,
        //         $transaction->investor->email,
        //         'Your Document - ' . strtoupper($docType),
        //         "Dear {$transaction->investor->name},<br><br>This is your soft copy of your document – <b>{$document->type}</b>.<br><br>Regards,<br>Shuruup Team",
        //         [
        //             [
        //                 'url' => $documentUrl,
        //                 'name' => $document->type . '.pdf'
        //             ]
        //         ]
        //     );
        // }
        return UtillsHelper::json(1, ['message' => 'Document sent'], 200);
    }

    function pendingTasks(): JsonResponse
    {
        $request = request();
        $pendingPayments = PrimaryTransactionModel::whereHas('investor', function ($query) use ($request) {
            $query->where('partner_id', $request->user()->id);
        })->where('status', '6')->count();

        $document_sign = PrimaryTransactionModel::whereHas('investor', function ($query) use ($request) {
            $query->where('partner_id', $request->user()->id);
        })->wherein('status', [2, 5, 9])->count();

        $pendingKyc = InvestorModel::where('partner_id', $request->user()->id)->where('preipo_kyc_status', 0)->where('is_deleted', '0')->count();
        $pendingAIF = InvestorModel::where('partner_id', $request->user()->id)->where('aif_status', 0)->where('is_deleted', '0')->count();

        return UtillsHelper::json(
            1,
            [
                'message' => 'Pending Tasks',
                'data' => [
                    'pending_payment' => $pendingPayments,
                    'document_sign' => $document_sign,
                    'pending_kyc' => $pendingKyc,
                    'pending_aif' => $pendingAIF,
                ]
            ],
            200
        );
    }

    function investorKYCSubmit(): JsonResponse
    {
        return $this->partnerRepo->investorKYCSubmit();
    }

    function forgot(): JsonResponse
    {
        return $this->partnerRepo->forgot();
    }

    function verifyOtp(): JsonResponse
    {
        return $this->partnerRepo->verifyOtp();
    }

    function changePassword(): JsonResponse
    {
        return $this->partnerRepo->changePassword();
    }

    function resendOtp(): JsonResponse
    {
        return $this->partnerRepo->resendOtp();
    }

    function recentTransaction(): JsonResponse
    {
        $request = request();
        $userId = $request->user()->id;
        $allTransactions = [];

        // Get primary transactions
        $primaryTransactions = PrimaryTransactionModel::where('investor_id', $userId)
            ->with('startup.details', 'startup.cms')
            ->get();

        foreach ($primaryTransactions as $transaction) {
            $allTransactions[] = [
                'type' => 'primary',
                'primary' => $transaction,
                'created_at' => $transaction->created_at
            ];
        }

        // Get secondary sell transactions
        $sellRequests = SecondarySellRequestModel::where('investor_id', $userId)
            ->with('startup.cms')
            ->with(['transactions' => function ($query) {
                $query->whereNotIn('status', [2, 3])->with('buyer');
            }])
            ->get();

        foreach ($sellRequests as $sellRequest) {
            $allTransactions[] = [
                'type' => 'secondary',
                'secondary' => [
                    'type' => 'sell',
                    'sell' => $sellRequest,
                    'buy' => null,
                ],
                'created_at' => $sellRequest->created_at
            ];
        }

        // Get secondary buy transactions
        $buyTransactions = SecondaryTransactionModel::where('buyer_id', $userId)
            ->with('startup.cms', 'escrow')
            ->get();

        foreach ($buyTransactions as $transaction) {
            $allTransactions[] = [
                'type' => 'secondary',
                'secondary' => [
                    'type' => 'buy',
                    'sell' => null,
                    'buy' => $transaction,
                ],
                'created_at' => $transaction->created_at
            ];
        }

        // Get pre-IPO transactions
        $preIpoTransactions = PreIpoModel::where('investor_id', $userId)
            ->with('company')
            ->get()
            ->map(function ($transaction) {
                $transaction->company->makeHidden(['transaction']);
                return $transaction;
            });

        foreach ($preIpoTransactions as $transaction) {
            $allTransactions[] = [
                'type' => 'preipo',
                'preipo' => $transaction,
                'created_at' => $transaction->created_at
            ];
        }

        // Sort all transactions by created_at date (newest first)
        usort($allTransactions, function ($a, $b) {
            return $b['created_at'] <=> $a['created_at'];
        });

        return UtillsHelper::json(1, [
            'message' => 'All Transaction List',
            'data' => $allTransactions
        ], 200);
    }

    function transactionList(): JsonResponse
    {
        $request = request();

        $transactions = PrimaryTransactionModel::whereHas('investor', function ($query) use ($request) {
            $query->where('partner_id', $request->user()->id);
        })->with(['startup.details', 'startup.cms', 'investor']);

        if ($request->pending_doc_sign) {
            $transactions->wherein('status', [2, 5, 9]);
        }

        if ($request->pending_payment) {
            $transactions->where('status', 6);
        }

        return UtillsHelper::json(
            1,
            [
                'message' => 'Transaction List',
                'data' => $transactions->get()
            ],
            200
        );
    }

    function transactionDetails(): JsonResponse
    {
        $request = request();
        $validation = Validator::make($request->all(), [
            'transaction_id'  => 'required',
        ]);

        if ($validation->fails()) {
            return UtillsHelper::json(
                0,
                [
                    'message' => $validation->errors()->first()
                ],
                200
            );
        }

        $transaction = PrimaryTransactionModel::with([
            'startup.cms',
            'investor'
        ])->where('id', $request->transaction_id)
            ->whereHas('investor', function ($query) use ($request) {
                $query->where('partner_id', $request->user()->id);
            })
            ->first();


        if (!$transaction) {
            return UtillsHelper::json(0, ['message' => 'Transaction not found or does not belong to the partner.']);
        }
        $transaction->status_list = PrimaryTransactionHelper::getStatusListForApplication($transaction);

        return UtillsHelper::json(1, ['message' => 'Transaction details fetched successfully', 'data' => $transaction]);
    }

    function dashboard()
    {
        $partnerId = request()->user()->id;
        $request = request();

        $partner = PartnerModel::with([
            'investor' => function ($query) {
                $query->where('is_deleted', '0');
            },
            'investor.portfolio.startup.sector',
            'investor.portfolio.startup.details',
            'investor.portfolio.startup.cms',
            'investor.portfolio.startup.sharePrices' => function ($query) {
                $query->orderByDesc('created_at')->limit(1);
            }
        ])->find($partnerId);

        if (!$partner) {
            return response()->json(['error' => 'Partner not found'], 404);
        }

        $investors = $partner->investor;
        $portfolio = $investors->flatMap->portfolio;

        // Total startups invested in
        $totalStartups = $portfolio->pluck('startup_id')->unique()->count();

        // Total investors
        $totalInvestors = $investors->count();

        // Total amount invested
        $totalAmountInvested = $portfolio->sum('investment_amount');

        // List of investors with their total startups invested and amount invested
        $investorsData = $investors->map(function ($investor) {
            $totalStartups = $investor->portfolio->pluck('startup_id')->unique()->count();
            $amountInvested = $investor->portfolio->sum('investment_amount');

            return [
                'investor_id' => $investor->id,
                'name' => $investor->name,
                'total_startups' => $totalStartups,
                'amount_invested' => $amountInvested,
            ];
        });

        $topInvestors = $investorsData->sortByDesc('amount_invested')->take(3)->values()->toArray();


        $sectorArray = [];
        $investmentGrowth = [];

        $portfolio->each(function ($investment) use (&$sectorArray, &$investmentGrowth) {
            $startup = $investment->startup;
            $sectorId = $startup->sector->id;
            $sectorName = $startup->sector->name;
            $startupId = $startup->id;
            $startupName = $startup->brand_name;
            $investmentAmount = $investment->investment_amount;
            $latestSharePrice = $startup->sharePrices->first()->price ?? $investment->purchase_price;
            $currentValue = $investment->shares * $latestSharePrice;
            $startupLogo = $startup->details->logo;

            if (!isset($sectorArray[$sectorId])) {
                $sectorArray[$sectorId] = [
                    'id' => $sectorId,
                    'name' => $sectorName,
                    'total_investment' => 0,
                    'startups' => []
                ];
            }

            $sectorArray[$sectorId]['startups'][] = [
                'investor_name' => $investment->investor->name,
                'startup_id' => $startupId,
                'startup_name' => $startupName,
                'investment_amount' => $investmentAmount,
                'current_value' => $currentValue,
                'purchase_price' => $investment->purchase_price,
                'shares' => $investment->shares,
                'created_at' => $investment->created_at
            ];
            $sectorArray[$sectorId]['total_investment'] += $investmentAmount;
            if (!isset($investmentGrowth[$startupId])) {
                $investmentGrowth[$startupId] = [
                    'startup_id' => $startupId,
                    'startup_name' => $startupName,
                    'total_invested_amount' => 0,
                    'current_value' => $currentValue,
                    'logo' => $startupLogo,
                ];
            }
            $investmentGrowth[$startupId]['total_invested_amount'] += $investmentAmount;
            $investmentGrowth[$startupId]['current_value'] = $currentValue;
        });
        foreach ($sectorArray as $sectorId => &$sector) {
            usort($sector['startups'], function ($a, $b) {
                return $a['startup_id'] <=> $b['startup_id'];
            });
        }
        unset($sector);
        $monthlyInvestments = [];
        $quarterlyInvestments = [];
        $quartersList = DateTimeHelper::getLast6QuartersDates();
        foreach ($quartersList as $qkey => $qvalue) {
            $ptotalInvestment = PrimaryTransactionModel::whereHas('investor', function ($query) use ($request) {
                $query->where('partner_id', $request->user()->id);
            })->where('status', '>', '6')->whereBetween('created_at', [$qvalue['start'], $qvalue['end']])
                ->sum('investment_amount');
            $stotalInvestment = SecondaryTransactionModel::whereHas('buyer', function ($query) use ($request) {
                $query->where('partner_id', $request->user()->id);
            })->where('status', '>', '5')->whereBetween('created_at', [$qvalue['start'], $qvalue['end']])
                ->sum('investment_amount');

            $quarterlyInvestments[] = [
                'quater'           => $qvalue['quater'],
                'start'            => $qvalue['start'],
                'end'              => $qvalue['end'],
                'total_investment' => $ptotalInvestment + $stotalInvestment,
            ];
        }

        $monthsList = DateTimeHelper::getLast6Months();
        foreach ($monthsList as $singMonth) {
            $ptotalInvestment = PrimaryTransactionModel::whereHas('investor', function ($query) use ($request) {
                $query->where('partner_id', $request->user()->id);
            })->where('status', '>', '6')->whereBetween('created_at', [$singMonth['start'], $singMonth['end']])
                ->sum('investment_amount');
            $stotalInvestment = SecondaryTransactionModel::whereHas('buyer', function ($query) use ($request) {
                $query->where('partner_id', $request->user()->id);
            })->where('status', '>', '5')->whereBetween('created_at', [$singMonth['start'], $singMonth['end']])
                ->sum('investment_amount');

            $monthlyInvestments[] = [
                'month'            => $singMonth['month'],
                'start'            => $singMonth['start'],
                'end'              => $singMonth['end'],
                'total_investment' => $ptotalInvestment + $stotalInvestment,
            ];
        }


        $pendingPayments = PrimaryTransactionModel::whereHas('investor', function ($query) use ($request) {
            $query->where('partner_id', $request->user()->id);
        })->where('status', '6')->count();

        $document_sign = PrimaryTransactionModel::whereHas('investor', function ($query) use ($request) {
            $query->where('partner_id', $request->user()->id);
        })->wherein('status', [2, 5, 9])->count();

        $pendingKyc = InvestorModel::where('partner_id', $request->user()->id)->where('preipo_kyc_status', 0)->where('is_deleted', '0')->count();

        $kycInvestorList = InvestorModel::select('id', 'name', 'mobile_number', 'email', 'preipo_kyc_status as kyc_status')->where('partner_id', $request->user()->id)->where('is_deleted', '0')->get();
        $activeInvestorList = InvestorModel::select('id', 'name', 'mobile_number', 'email', 'is_active')->where('partner_id', $request->user()->id)->where('is_deleted', '0')->get();

        $data = [
            'total_startups' => $totalStartups,
            'total_investors' => $totalInvestors,
            'total_amount_invested' => $totalAmountInvested,
            'pending_payment' => $pendingPayments,
            'pending_document_sign' => $document_sign,
            'pending_kyc' => $pendingKyc,
            'investor_chart' => [
                'kyc'   => $kycInvestorList,
                'active'   => $activeInvestorList
            ],
            'average_ticket_size' => $portfolio->avg('investment_amount'),
            'investors' => $investorsData->toArray(),
            'top_investors' => $topInvestors,
            'sectors' => array_values($sectorArray),
            'investment_growth' => array_values($investmentGrowth),
            'investments' => [
                'monthly' => array_reverse($monthlyInvestments),
                'quarterly' => $quarterlyInvestments
            ]
        ];

        return UtillsHelper::json(
            1,
            [
                'message' => 'Dashboard',
                'data' => $data
            ],
            200
        );
    }

    function investedStartupMIS(): JsonResponse
    {
        return $this->partnerRepo->getInvestedStartupMIS();
    }
    function dashboardPreIpo()
    {
        $partnerId = request()->user()->id;
        $request = request();

        $partner = PartnerModel::with([
            'investor' => function ($query) {
                $query->where('is_deleted', '0');
            },
            'investor.pportfolio.company.sector',
            'investor.pportfolio.company.sharePrices' => function ($query) {
                $query->orderByDesc('date')->limit(1);
            }
        ])->find($partnerId);

        if (!$partner) {
            return response()->json(['error' => 'Partner not found'], 404);
        }

        $investors = $partner->investor;
        $portfolio = $investors->flatMap->pportfolio;

        // Total startups invested in
        $totalStartups = $portfolio->pluck('company_id')->unique()->count();

        // Total investors
        $totalInvestors = $investors->count();

        // Total amount invested
        $totalAmountInvested = $portfolio->sum('investment_amount');

        // List of investors with their total startups invested and amount invested
        $investorsData = $investors->map(function ($investor) {
            $totalStartups = $investor->pportfolio->pluck('company_id')->unique()->count();
            $amountInvested = $investor->pportfolio->sum('investment_amount');

            return [
                'investor_id' => $investor->id,
                'name' => $investor->name,
                'total_startups' => $totalStartups,
                'amount_invested' => $amountInvested,
            ];
        });

        $topInvestors = $investorsData->sortByDesc('amount_invested')->take(3)->values()->toArray();


        $sectorArray = [];
        $investmentGrowth = [];

        $portfolio->each(function ($investment) use (&$sectorArray, &$investmentGrowth) {
            $startup = $investment->company;
            $sectorId = $startup->sector->id;
            $sectorName = $startup->sector->name;
            $startupId = $startup->id;
            $startupName = $startup->brand_name;
            $investmentAmount = $investment->investment_amount;
            $latestSharePrice = $startup->sharePrices->first()->price ?? $investment->purchase_price;
            $currentValue = $investment->shares * $latestSharePrice;
            $startupLogo = $startup->logo;

            if (!isset($sectorArray[$sectorId])) {
                $sectorArray[$sectorId] = [
                    'id' => $sectorId,
                    'name' => $sectorName,
                    'total_investment' => 0,
                    'startups' => []
                ];
            }

            $sectorArray[$sectorId]['startups'][] = [
                'investor_name' => $investment->investor->name,
                'startup_id' => $startupId,
                'startup_name' => $startupName,
                'investment_amount' => $investmentAmount,
                'current_value' => $currentValue,
                'purchase_price' => $investment->purchase_price,
                'shares' => $investment->shares,
                'created_at' => $investment->created_at
            ];
            $sectorArray[$sectorId]['total_investment'] += $investmentAmount;

            if (!isset($investmentGrowth[$startupId])) {
                $investmentGrowth[$startupId] = [
                    'startup_id' => $startupId,
                    'startup_name' => $startupName,
                    'total_invested_amount' => 0,
                    'current_value' => $currentValue,
                    'logo' => $startupLogo,
                ];
            }

            $investmentGrowth[$startupId]['total_invested_amount'] += $investmentAmount;
            $investmentGrowth[$startupId]['current_value'] = $currentValue;
        });

        $monthlyInvestments = [];
        $quarterlyInvestments = [];
        $quartersList = DateTimeHelper::getLast6QuartersDates();
        foreach ($quartersList as $qkey => $qvalue) {
            $ptotalInvestment = PreIpoModel::whereHas('investor', function ($query) use ($request) {
                $query->where('partner_id', $request->user()->id);
            })->where('status', '5')->whereBetween('created_at', [$qvalue['start'], $qvalue['end']])
                ->sum('investment_amount');

            $quarterlyInvestments[] = [
                'quater'           => $qvalue['quater'],
                'start'            => $qvalue['start'],
                'end'              => $qvalue['end'],
                'total_investment' => $ptotalInvestment,
            ];
        }

        $monthsList = DateTimeHelper::getLast6Months();
        foreach ($monthsList as $singMonth) {
            $ptotalInvestment = PreIpoModel::whereHas('investor', function ($query) use ($request) {
                $query->where('partner_id', $request->user()->id);
            })->where('status', '5')->whereBetween('created_at', [$singMonth['start'], $singMonth['end']])
                ->sum('investment_amount');

            $monthlyInvestments[] = [
                'month'            => $singMonth['month'],
                'start'            => $singMonth['start'],
                'end'              => $singMonth['end'],
                'total_investment' => $ptotalInvestment,
            ];
        }


        $pendingPayments = PreIpoModel::whereHas('investor', function ($query) use ($request) {
            $query->where('partner_id', $request->user()->id);
        })->where('status', '3')->count();

        $document_sign = PreIpoModel::whereHas('investor', function ($query) use ($request) {
            $query->where('partner_id', $request->user()->id);
        })->where('status', 2)->count();

        $pendingKyc = InvestorModel::where('partner_id', $request->user()->id)->where('preipo_kyc_status', 0)->where('is_deleted', '0')->count();

        $kycInvestorList = InvestorModel::select('id', 'name', 'mobile_number', 'email', 'preipo_kyc_status as kyc_status')->where('partner_id', $request->user()->id)->where('is_deleted', '0')->get();
        $activeInvestorList = InvestorModel::select('id', 'name', 'mobile_number', 'email', 'is_active')->where('partner_id', $request->user()->id)->where('is_deleted', '0')->get();

        $data = [
            'total_startups' => $totalStartups,
            'total_investors' => $totalInvestors,
            'total_amount_invested' => $totalAmountInvested,
            'pending_payment' => $pendingPayments,
            'pending_document_sign' => $document_sign,
            'pending_kyc' => $pendingKyc,
            'investor_chart' => [
                'kyc'   => $kycInvestorList,
                'active'   => $activeInvestorList
            ],
            'average_ticket_size' => $portfolio->avg('investment_amount'),
            'investors' => $investorsData->toArray(),
            'top_investors' => $topInvestors,
            'sectors' => array_values($sectorArray),
            'investment_growth' => array_values($investmentGrowth),
            'investments' => [
                'monthly' => array_reverse($monthlyInvestments),
                'quarterly' => $quarterlyInvestments
            ]
        ];

        return UtillsHelper::json(
            1,
            [
                'message' => 'Dashboard',
                'data' => $data
            ],
            200
        );
    }

    function investorPost(): JsonResponse
    {
        return $this->invRepo->investorSave();
    }

    function investorPostUpdate(): JsonResponse
    {
        return $this->invRepo->investorSave();
    }

    function investorGet(): JsonResponse
    {
        return $this->invRepo->investorList();
    }


    function relationManagerGet(): JsonResponse
    {
        $request = request();
        $relationManager = PartnerModel::where('type', PartnerTypeEnum::relationmanager->value)->where('parent_id', $request->user()->id)->get();
        return UtillsHelper::json(1, ['message' => 'Relation Managers', 'data' => $relationManager]);
    }

    function profile(): JsonResponse
    {
        return $this->partnerRepo->profile();
    }

    function profileSave(): JsonResponse
    {
        return $this->partnerRepo->profileSave();
    }

    function transactions(): JsonResponse
    {
        $request = request();

        $transactions = PrimaryTransactionModel::whereHas('investor', function ($query) use ($request) {
            $query->where('partner_id', $request->user()->id);
        })->with(['startup.details', 'startup.cms', 'investor']);

        if ($request->pending_doc_sign) {
            $transactions->wherein('status', [2, 5, 9]);
        }

        if ($request->pending_payment) {
            $transactions->where('status', 6);
        }

        return UtillsHelper::json(
            1,
            [
                'message' => 'Transaction List',
                'data' => $transactions->get()
            ],
            200
        );
    }

    function investorEarning(): JsonResponse
    {
        $request = request();

        $partner = PartnerModel::with([
            'investor.portfolio',
            'investor.pportfolio',
            'investor.perIpoTransactions'
        ])->find($request->user()->id);

        $totalInvestorCount = $partner->investor->count();
        $totalListedInvestment = 0;
        $totalPreIpoInvestment = 0;
        $totalCommissionFromPreIpo = 0;

        $investorDataList = $partner->investor->map(function ($investor) use ($partner, &$totalListedInvestment, &$totalPreIpoInvestment, &$totalCommissionFromPreIpo) {
            $listedInvestment = $investor->portfolio->sum('investment_amount');
            $preIpoInvestment = $investor->pportfolio->sum('investment_amount');

            $totalListedInvestment += $listedInvestment;
            $totalPreIpoInvestment += $preIpoInvestment;

            $listedCommission = ($partner->commission > 0 && $listedInvestment > 0)
                ? ($partner->commission / 100) * $listedInvestment
                : 0;

            $preIpoCommission = 0;

            foreach ($investor->perIpoTransactions as $transaction) {
                $priceDifference = $transaction->share_price - $transaction->distributer_price;

                if ($priceDifference > 0) {
                    $commissionFromTransaction = $priceDifference * $transaction->shares;
                    $preIpoCommission += $commissionFromTransaction;
                    $totalCommissionFromPreIpo += $commissionFromTransaction;
                }
            }

            return [
                'investor_id'       => $investor->id,
                'name'              => $investor->name,
                'profile_photo'     => $investor->profile_photo,
                'total_investment'  => $listedInvestment + $preIpoInvestment,
                'commission_earned' => $listedCommission + $preIpoCommission,
            ];
        });

        $totalListedCommission = ($partner->commission > 0 && $totalListedInvestment > 0)
            ? ($partner->commission / 100) * $totalListedInvestment
            : 0;

        return UtillsHelper::json(
            1,
            [
                'message' => 'Investor Earnings',
                'data' => [
                    'total_investors'   => $totalInvestorCount,
                    'total_investment'  => $totalListedInvestment + $totalPreIpoInvestment,
                    'commission_earned' => $totalListedCommission + $totalCommissionFromPreIpo,
                    'investors_list'    => $investorDataList,
                ]
            ],
            200
        );
    }

    function partnerEarning(): JsonResponse
    {
        $request = request();
        $partner = PartnerModel::with('childPartner.investor.portfolio')->find($request->user()->id);

        $childPartners = $partner->childPartner;

        // Calculate total investment and commission from child partners
        $totalInvestment = $childPartners->flatMap(function ($childPartner) {
            return $childPartner->investor->flatMap(function ($investor) {
                return $investor->portfolio;
            });
        })->sum('investment_amount');

        $totalCommissionEarnedFromChildPartners = $childPartners->sum(function ($childPartner) {
            $totalInvestmentByChild = $childPartner->investor->flatMap(function ($investor) {
                return $investor->portfolio;
            })->sum('investment_amount');

            return ($childPartner->commission > 0 && $totalInvestmentByChild > 0)
                ? ($childPartner->commission / 100) * $totalInvestmentByChild
                : 0;
        });

        // Calculate partner commission earned
        $partnerCommissionEarned = ($partner->commission > 0 && $totalInvestment > 0)
            ? ($partner->commission / 100) * $totalInvestment - $totalCommissionEarnedFromChildPartners
            : 0;

        // Create child partners list with commission calculations
        $childPartnerList = $childPartners->map(function ($childPartner) use ($partner) {
            $totalInvestmentByChild = $childPartner->investor->flatMap(function ($investor) {
                return $investor->portfolio;
            })->sum('investment_amount');

            $commissionEarnedByChild = ($childPartner->commission > 0 && $totalInvestmentByChild > 0)
                ? ($childPartner->commission / 100) * $totalInvestmentByChild
                : 0;

            $singleCommissionEarned = ($partner->commission > 0 && $totalInvestmentByChild > 0)
                ? ($partner->commission / 100) * $totalInvestmentByChild - $commissionEarnedByChild
                : 0;

            return [
                'partner_id' => $childPartner->id,
                'name' => $childPartner->name,
                'partner_total_investment' => $totalInvestmentByChild,
                'partner_commission_percentage' => $partner->commission,
                'partner_commission_earned' => $commissionEarnedByChild,
                'commission_earned_from_this_partner' => $singleCommissionEarned,
            ];
        });

        return UtillsHelper::json(
            1,
            [
                'message' => 'Partner and Child Partners Earnings',
                'data' => [
                    'total_partners' => $childPartners->count(),
                    'total_investment' => $totalInvestment,
                    'total_commission_earned' => $partnerCommissionEarned,
                    'list' => $childPartnerList,
                ]
            ],
            200
        );
    }

    function channelPartnerlist(): JsonResponse
    {
        return $this->partnerRepo->channelPartnerlist();
    }

    function channelPartnerSave(): JsonResponse
    {
        return $this->partnerRepo->channelPartnerSave();
    }

    function changePasswordSave(): JsonResponse
    {
        return $this->partnerRepo->changePasswordSave();
    }

    function documents(): JsonResponse
    {
        return $this->partnerRepo->documents();
    }

    function notifications(): JsonResponse
    {
        return $this->partnerRepo->notifications();
    }

    function newChannelPartnerSave(): JsonResponse
    {
        return $this->partnerRepo->newDistributorSave();
    }
}
