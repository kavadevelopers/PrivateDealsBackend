<?php

namespace App\Jobs;

use App\Enums\NotificationTypeEnum;
use App\Enums\Utills\StatusEnum;
use App\Enums\WpMessageTypeEnum;
use App\Helpers\SecondaryTransactionHelper;
use App\Helpers\UtillsHelper;
use App\Models\InvestorModel;
use App\Models\SecondaryExistingInvestorModel;
use App\Models\SecondarySellRequestModel;
use App\Models\SecondaryTransactionModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SecondaryAllocationJob implements ShouldQueue
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
        $sellReq = SecondarySellRequestModel::where('id', $this->secondary_request_id)->first();
        if ($sellReq) {
            $approvedList = SecondaryTransactionModel::where('sell_request_id', $this->secondary_request_id)->where('status', '1')->where('shares', '>', '0');
            if ($approvedList->count() > 0) {
                foreach ($approvedList->get() as $key => $item) {
                    $secTransaction = $item;
                    $secTransaction->status = 1;
                    $secTransaction->save();
                    SecondaryTransactionHelper::sendSH4($secTransaction);

                    UtillsHelper::sendNotification($secTransaction->seller->id, InvestorModel::class, 'secondary-transactions', 'Shares Allocation', $secTransaction->shares . ' Share alloted to ' . $secTransaction->buyer->name . ' SH4 sent to you please sign the document. Check SMS for sign link');

                    UtillsHelper::sendWpMessage(
                        NotificationTypeEnum::event,
                        'notify_seller_after_buyer_purchases_share',
                        WpMessageTypeEnum::text,
                        $secTransaction->seller->mobile_number,
                        $secTransaction->seller->name,
                        NULL,
                        [],
                        [$secTransaction->seller->name, $secTransaction->buyer->name, $secTransaction->shares, $secTransaction->share_price],
                        ['transaction_id' => $secTransaction->id]
                    );

                    UtillsHelper::sendNotification($secTransaction->buyer->id, InvestorModel::class, 'secondary-transactions', 'Shares Allocation', $secTransaction->shares . ' Share alloted to You. SH4 sent to you please sign the document. Check SMS for sign link');

                    UtillsHelper::sendWpMessage(
                        NotificationTypeEnum::event,
                        'notify_buyer_shares_alloted',
                        WpMessageTypeEnum::text,
                        $secTransaction->buyer->mobile_number,
                        $secTransaction->buyer->name,
                        NULL,
                        [],
                        [$secTransaction->buyer->name, $secTransaction->shares, $secTransaction->share_price],
                        ['transaction_id' => $secTransaction->id]
                    );
                }
            }
        }
    }
}
