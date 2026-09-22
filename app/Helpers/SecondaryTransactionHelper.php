<?php

namespace App\Helpers;

use App\Enums\DocumentTypeEnum;
use App\Enums\NotificationTypeEnum;
use App\Enums\Utills\StatusEnum;
use App\Enums\WpMessageTypeEnum;
use App\Jobs\SecondaryAllocationJob;
use App\Jobs\SecondaryRofrJob;
use App\Models\DocumentsModel;
use App\Models\InvestorModel;
use App\Models\ReportErrorLogModel;
use App\Models\SecondaryEscrowAccountModel;
use App\Models\SecondaryExistingInvestorModel;
use App\Models\SecondarySellRequestModel;
use App\Models\SecondaryTransactionModel;
use App\Models\StartupManageCaptableModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SecondaryTransactionHelper
{

    static function getSellRequestStatusListForApplication(SecondarySellRequestModel $transaction): array
    {
        $list = [];

        $list[] = [
            'title'         => 'Sell Request Placed',
            'description'   => 'Sell request placed by investor',
            'date'          => $transaction->created_at,
            'document'      => null,
            'action'        => null,
            'is_active'     => in_array($transaction->status, [0, 1]) ? true : false,
        ];

        if ($transaction->status == 2) {
            $list[] = [
                'title'         => 'Request Rejected',
                'description'   => 'Request Rejected by startup',
                'date'          => $transaction->updated_at,
                'document'      => null,
                'action'        => null,
                'is_active'     => $transaction->status == 2 ? true : false,
            ];
        } else {
            $list[] = [
                'title'         => 'In Progress',
                'description'   => 'Transaction in progress',
                'date'          => null,
                'document'      => null,
                'action'        => null,
                'is_active'     => in_array($transaction->status, [3, 4, 5, 6, 7, 8])  ? true : false,
            ];

            $list[] = [
                'title'         => 'Sold',
                'description'   => 'Transaction completed',
                'date'          => null,
                'document'      => null,
                'action'        => null,
                'is_active'     => in_array($transaction->status, [9])  ? true : false,
            ];
        }

        return $list;
    }

    static function getTransactionStatusListForApplication(SecondaryTransactionModel $transaction): array
    {
        $list = [];
        $list[] = [
            'title'         => 'Committed',
            'description'   => 'Investment Committed',
            'date'          => $transaction->created_at,
            'document'      => null,
            'action'        => null,
            'is_active'     => in_array($transaction->status, [0, 1, 4]) ? true : false,
        ];

        if (in_array($transaction->status, [2, 3])) {
            if ($transaction->status == 2) {
                $list[] = [
                    'title'         => 'ROFR Rejected',
                    'description'   => 'ROFR Rejected by investor',
                    'date'          => $transaction->updated_at,
                    'document'      => null,
                    'action'        => null,
                    'is_active'     => $transaction->status == 2 ? true : false,
                ];
            } else {
                $list[] = [
                    'title'         => 'ROFR Expired',
                    'description'   => 'ROFR Expired by not responding',
                    'date'          => $transaction->updated_at,
                    'document'      => null,
                    'action'        => null,
                    'is_active'     => $transaction->status == 3 ? true : false,
                ];
            }
        } else {
            $list[] = [
                'title'         => 'SH4 Signed',
                'description'   => 'SH4 Agreement Signed',
                'date'          => $transaction->sh4_document->created_at ?? null,
                'document'      => $transaction->sh4_document,
                'action'        => null,
                'is_active'     => $transaction->status == 5 ? true : false,
            ];
            $list[] = [
                'title'         => 'Payment received',
                'description'   => 'Payment received for the transaction',
                'date'          => $transaction->payment_receipt->created_at ?? null,
                'document'      => $transaction->payment_receipt,
                'action'        => null,
                'is_active'     => $transaction->status == 6 ? true : false,
            ];
            $list[] = [
                'title'         => 'Share transfered',
                'description'   => 'Share transfered for the transaction',
                'date'          => $transaction->share_transfer_receipt->created_at ?? null,
                'document'      => $transaction->share_transfer_receipt,
                'action'        => null,
                'is_active'     => $transaction->status == 7 ? true : false,
            ];

            $list[] = [
                'title'         => 'Completed',
                'description'   => 'Transaction successfully completed',
                'date'          => $transaction->updated_at,
                'document'      => null,
                'action'        => null,
                'is_active'     => $transaction->status == 8 ? true : false
            ];
        }
        return $list;
    }

    static function sendShareRequest($sellRequest): void
    {
        SecondaryRofrJob::dispatch($sellRequest->id);
    }

    static function allotShares($sellRequest): void
    {
        $allotees = SecondaryTransactionModel::with(['buyer'])
            ->where('sell_request_id', $sellRequest->id)
            ->where('status', '1')
            ->get();

        $totalShares = $sellRequest->shares;
        $remainingShares = $totalShares;
        $startupId = $sellRequest->startup_id;

        // Get cap table data for all buyers in one query
        $buyerMobileNumbers = $allotees->pluck('buyer.mobile_number');
        $capTableEntries = StartupManageCaptableModel::where('startup_id', $startupId)
            ->whereIn('mobile_number', $buyerMobileNumbers)
            ->get()
            ->keyBy('mobile_number'); // Organize by mobile number for quick lookup

        // Calculate the total holding percentage in a single loop
        $totalHoldingPercentage = $capTableEntries->sum('holding_percentage');

        if ($totalHoldingPercentage == 0) {
            Log::alert("Total holding percentage is zero, cannot proceed with allocation.");
            return;
        }

        $allocations = [];
        $totalAllocatedShares = 0;

        // Loop through allotees to calculate their share allocations
        foreach ($allotees as $allotee) {
            $buyer = $allotee->buyer;
            $capTableEntry = $capTableEntries->get($buyer->mobile_number);

            if ($capTableEntry) {
                // Calculate share allotment based on the investor's holding percentage
                $exactSharesToAllot = ($capTableEntry->holding_percentage * $totalShares) / $totalHoldingPercentage;
                $roundedSharesToAllot = round($exactSharesToAllot);
                $remainder = $exactSharesToAllot - $roundedSharesToAllot;

                $allocations[] = [
                    'allotee' => $allotee,
                    'wholeShares' => $roundedSharesToAllot,
                    'remainder' => $remainder,
                ];

                $remainingShares -= $roundedSharesToAllot;
                $totalAllocatedShares += $roundedSharesToAllot;
            }
        }

        // Sort allocations by remainder in descending order to distribute extra shares fairly
        usort($allocations, fn($a, $b) => $b['remainder'] <=> $a['remainder']);

        // Distribute remaining shares based on the highest remainders
        foreach ($allocations as &$allocation) {
            if ($remainingShares <= 0) break;

            $allocation['wholeShares'] += 1;
            $remainingShares--;
        }

        // Save final share allocations
        foreach ($allocations as $allocation) {
            /** @var SecondaryExistingInvestorModel $item */
            $item = $allocation['allotee'];
            $item->shares = $allocation['wholeShares'];
            $item->save();
        }

        // Mark the sell request as processed
        $sellRequest->status = 8;
        $sellRequest->save();

        SecondaryAllocationJob::dispatch($sellRequest->id);
    }

    static function sendSH4($transaction): void
    {
        if ($transaction->startup && $transaction->buyer && $transaction->seller) {
            if (
                $transaction->startup->mobile_number != $transaction->buyer->mobile_number &&
                $transaction->startup->mobile_number != $transaction->seller->mobile_number &&
                $transaction->buyer->mobile_number != $transaction->seller->mobile_number
            ) {
                $sendSH = DigioHelper::sendSHNow($transaction);
                if ($sendSH->getStatusCode() == "200") {
                    $getDocResponse = json_decode($sendSH->getBody()->getContents());
                    $ssaId = $getDocResponse->id;
                    $document = new DocumentsModel();
                    $document->api_id = $ssaId;
                    $document->type = DocumentTypeEnum::secondarysh;
                    $document->meta = [
                        'name' => 'SH4 - ' . $transaction->startup->brand_name,
                        'sname' => 'SH4 - ' . $transaction->buyer->name . ' & ' . $transaction->seller->name,
                        'investor' => [
                            $transaction->buyer->id,
                            $transaction->seller->id,
                        ],
                        'startup' => [
                            $transaction->startup->id
                        ],
                        'secondary_transaction' => [
                            $transaction->id
                        ]
                    ];
                    $document->save();

                    $transaction->status = 4;
                    $transaction->save();
                } else {
                    $getDocResponse = json_decode($sendSH->getBody()->getContents());
                    ReportErrorLogModel::create([
                        'type' => 'Digio',
                        'subtype'   => 'SH4 Send api error',
                        'description'   => $getDocResponse,
                        'notes'         => 'transaction = ' . $transaction->id
                    ]);
                }
            } else {
                ReportErrorLogModel::create([
                    'type' => 'Digio',
                    'subtype'   => 'SH4 Send identifier problem',
                    'description'   => 'Check startup, buyer and seller mobile number',
                    'notes'         => 'transaction = ' . $transaction->id
                ]);
            }
        } else {
            ReportErrorLogModel::create([
                'type' => 'Digio',
                'subtype'   => 'SH4 Send data error',
                'description'   =>
                'Data proble check the data here = $transaction->startup && $transaction->buyer && $transaction->seller',
                'notes'         => 'transaction = ' . $transaction->id
            ]);
        }
    }

    static function changeTransactionStatus($document): void
    {
        if ($document) {
            foreach ($document->meta->secondary_transaction as $key => $value) {
                $transaction = SecondaryTransactionModel::find($value);
                if ($transaction) {
                    $transaction->status = 5;
                    $transaction->save();

                    $escrow = new SecondaryEscrowAccountModel;
                    $escrow->transaction_id = $transaction->id;
                    $escrow->account_id = 'xxxx1234';
                    $escrow->bank = 'icici';
                    $escrow->account_no = '87954612301';
                    $escrow->ifsc_code = 'ICICI24630';
                    $escrow->balance = 0;
                    $escrow->validity = '120';
                    $escrow->start_date = Carbon::now()->format('Y-m-d');
                    $escrow->end_date = Carbon::now()->addDays(120);
                    $escrow->save();

                    UtillsHelper::sendNotification($transaction->seller->id, InvestorModel::class, 'secondary-transactions', 'Escrow Account', 'Escrow account opened for the transaction for ' . $transaction->buyer->name);

                    UtillsHelper::sendWpMessage(
                        NotificationTypeEnum::event,
                        'notify_buyer_seller_escrow_account_opened',
                        WpMessageTypeEnum::text,
                        $transaction->seller->mobile_number,
                        $transaction->seller->name,
                        NULL,
                        [],
                        [$transaction->seller->name, $transaction->shares, $transaction->share_price],
                        ['transaction_id' => $transaction->id]
                    );

                    UtillsHelper::sendNotification($transaction->buyer->id, InvestorModel::class, 'secondary-transactions', 'Escrow Account', 'Escrow account opened for the transaction we have sent bank account details to whatsapp transfer funds');

                    UtillsHelper::sendWpMessage(
                        NotificationTypeEnum::event,
                        'notify_buyer_to_transfer_payment_to_escrow',
                        WpMessageTypeEnum::text,
                        $transaction->buyer->mobile_number,
                        $transaction->buyer->name,
                        NULL,
                        [],
                        [$transaction->buyer->name, $transaction->shares, $transaction->share_price, $escrow->bank, $escrow->account_no, $escrow->ifsc_code],
                        ['transaction_id' => $transaction->id]
                    );
                }
            }
        }
    }

    static function changeOppotunityStatus(SecondaryTransactionModel $item): void
    {
        if ($item->status == '1') {
            $sellReq = SecondarySellRequestModel::where('id', $item->sell_request_id)->first();
            if ($sellReq) {
                if ($item->is_promoter) {
                    $sellReq->status = 4;
                } else {
                    $sellReq->status = 6;
                }
                $sellReq->save();
            }
        }

        $totalCount = SecondaryTransactionModel::where('sell_request_id', $item->sell_request_id)->count();
        $rejectedCount = SecondaryTransactionModel::where('sell_request_id', $item->sell_request_id)->wherein('status', ['2', '3'])->count();
        $pendingCount = SecondaryTransactionModel::where('sell_request_id', $item->sell_request_id)->where('status', '0')->count();
        $approveCount = SecondaryTransactionModel::where('sell_request_id', $item->sell_request_id)->where('status', '1')->count();
        if ($pendingCount == 0 && $approveCount > 0) {
            $sellReq = SecondarySellRequestModel::where('id', $item->sell_request_id)->first();
            if ($sellReq) {
                SecondaryTransactionHelper::allotShares($sellReq);
            }
        } else  if ($pendingCount == 0 && $approveCount == 0 && $item->is_promoter) {
            $sellReq = SecondarySellRequestModel::where('id', $item->sell_request_id)->first();
            if ($sellReq && $sellReq->status == 3) {
                SecondaryTransactionHelper::sendShareRequest($sellReq);
            }
        }

        if ($totalCount == $rejectedCount && !$item->is_promoter) {
            $sellReq = SecondarySellRequestModel::where('id', $item->sell_request_id)->first();
            if ($sellReq) {
                $sellReq->status = 7;
                $sellReq->save();


                UtillsHelper::sendNotification($sellReq->investor->id, InvestorModel::class, 'market-home', 'Sell request moved to market', 'Your sell request of ' . $sellReq->startup->brand_name . ' is moved to market');

                UtillsHelper::sendWpMessage(
                    NotificationTypeEnum::event,
                    'notify_investor_share_plac_in_market_2',
                    WpMessageTypeEnum::text,
                    $sellReq->investor->mobile_number,
                    $sellReq->investor->name,
                    NULL,
                    [],
                    [$sellReq->investor->name],
                    ['sell_request_id' => $sellReq->id]
                );
            }
        }
    }
}
