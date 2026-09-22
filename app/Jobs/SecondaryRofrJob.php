<?php

namespace App\Jobs;

use App\Enums\NotificationTypeEnum;
use App\Enums\Utills\StatusEnum;
use App\Enums\WpMessageTypeEnum;
use App\Helpers\UtillsHelper;
use App\Models\InvestorModel;
use App\Models\ReportErrorLogModel;
use App\Models\SecondaryExistingInvestorModel;
use App\Models\SecondarySellRequestModel;
use App\Models\SecondaryTransactionModel;
use App\Models\StartupManageCaptableModel;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SecondaryRofrJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $secondary_request_id;
    public function __construct(string $secondary_request_id)
    {
        $this->secondary_request_id = $secondary_request_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $sellRequest = SecondarySellRequestModel::where('id', $this->secondary_request_id)->first();
        if ($sellRequest) {
            $investors = false;
            if ($sellRequest->investor) {
                if ($sellRequest->status == '1') {
                    $investors = StartupManageCaptableModel::where('startup_id', $sellRequest->startup_id)->where('is_promoter', '1')->where('mobile_number', '!=', $sellRequest->investor->mobile_number)->get();
                    $sellRequest->status = 3;
                    $sellRequest->save();
                } else if ($sellRequest->status == '3') {
                    $investors = StartupManageCaptableModel::where('startup_id', $sellRequest->startup_id)->where('is_promoter', '0')->where('mobile_number', '!=', $sellRequest->investor->mobile_number)->get();
                    $sellRequest->status = 5;
                    $sellRequest->save();
                }
                if ($investors && $investors->count() > 0) {
                    foreach ($investors as $investor) {
                        $investorRow = InvestorModel::where('mobile_number', $investor->mobile_number)->where('is_deleted', '0')->where('registration_step', '3')->first();
                        if ($investorRow) {

                            $transaction = new SecondaryTransactionModel;
                            $transaction->status = 0;
                            $transaction->startup_id = $sellRequest->startup_id;
                            $transaction->portfolio_id = $sellRequest->portfolio_id;
                            $transaction->buyer_id = $investorRow->id;
                            $transaction->seller_id = $sellRequest->investor_id;
                            $transaction->sell_request_id = $sellRequest->id;
                            $transaction->instrument = $sellRequest->id;
                            $transaction->shares = $sellRequest->shares;
                            $transaction->share_price = $sellRequest->price;
                            $transaction->investment_amount = $sellRequest->price * $sellRequest->shares;
                            $transaction->is_promoter = $investor->is_promoter;
                            $transaction->expired_at = Carbon::now()->addDays(15)->format('Y-m-d H:i:s');
                            $transaction->save();

                            UtillsHelper::sendNotification($investorRow->id, InvestorModel::class, 'oppotunities.list', 'Secondary Opportunity', 'Secondary Opportunity received for startup' . $sellRequest->startup->brand_name);
                            $approveUrl = UtillsHelper::tokenUrlGenerate('secondary_oppotunity_approve', ['item_id' => $transaction->id]);
                            $rejectUrl = UtillsHelper::tokenUrlGenerate('secondary_oppotunity_reject', ['item_id' => $transaction->id]);
                            UtillsHelper::sendWpMessage(
                                NotificationTypeEnum::event,
                                'share_sell_request_4',
                                WpMessageTypeEnum::text,
                                $investorRow->mobile_number,
                                $investorRow->name,
                                NULL,
                                [$approveUrl, $rejectUrl],
                                [$investorRow->name, $sellRequest->shares, $sellRequest->startup->brand_name, $sellRequest->price, '15 days'],
                                ['secondary_existing_investors_id' => $transaction->id]
                            );
                        } else {
                            ReportErrorLogModel::create([
                                'type'      => 'secondary',
                                'subtype'   => 'Investor row not found',
                                'description'   => $investor->mobile_number . ' not found in captable'
                            ]);
                        }
                    }
                }
            } else {
                ReportErrorLogModel::create([
                    'type'      => 'secondary',
                    'subtype'   => 'Existing Investors',
                    'description'   => 'Seller not found'
                ]);
            }
        }
    }
}
