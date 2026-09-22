<?php

namespace App\Jobs\preipo;

use App\Helpers\PreIpoTransactionHelper;
use App\Models\PreIpoModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CancelNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $transaction_id;
    public function __construct(string $transaction_id)
    {
        $this->transaction_id = $transaction_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $transaction = PreIpoModel::with(['investor', 'company'])->find($this->transaction_id);
        if ($transaction) {
            PreIpoTransactionHelper::cancelTransactionNotification($transaction);
        }
    }
}
