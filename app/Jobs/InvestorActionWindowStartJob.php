<?php

namespace App\Jobs;

use App\Enums\NotificationTypeEnum;
use App\Enums\WpMessageTypeEnum;
use App\Helpers\UtillsHelper;
use App\Models\InvestorModel;
use App\Models\PreIpoModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InvestorActionWindowStartJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $transactionId;

    public function __construct($transactionId)
    {
        $this->transactionId = $transactionId;
    }

    public function handle(): void
    {
        $transaction = PreIpoModel::find($this->transactionId);
        if ($transaction && $transaction->investor && $transaction->investor->is_demo == 0) {
            $params = [
                $transaction->investor->name,
                $transaction->transaction_invoice_no,
            ];

            UtillsHelper::sendWpMessage(
                NotificationTypeEnum::event,
                'shuru_up_transaction_initiated_sun_copy',
                WpMessageTypeEnum::text,
                $transaction->investor->mobile_number,
                $transaction->investor->name,
                null,
                [],
                $params
            );
            UtillsHelper::sendNotification(
                $transaction->investor->id,
                InvestorModel::class,
                'preipo-transaction',
                'Private Equity Transaction',
                UtillsHelper::paramsToTemplate($params, 'Your transaction (ID: {{2}}) has been successfully initiated by PrivateDeals. 🕐 You have a total of 24 hours to complete your transaction process. Please ensure you complete it within this window, as your transaction will automatically expire after 24 hours. Please log in to your account and complete the process at the earliest. Thank you for choosing PrivateDeals!')
            );
        }
    }
}
