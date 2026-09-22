<?php

namespace App\Jobs;

use App\Helpers\PrimaryTransactionHelper;
use App\Models\PrimaryTransactionModel;
use App\Models\StartupModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OfferLetterSendJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $startup_id;
    public function __construct(string $startup_id)
    {
        $this->startup_id = $startup_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $startup = StartupModel::where('id', $this->startup_id)->first();
        if ($startup) {
            $transactions = PrimaryTransactionModel::where('startup_id', $this->startup_id)->where('status', '4')->get();
            foreach ($transactions as $key => $transaction) {
                PrimaryTransactionHelper::sendOffer($transaction);
            }
        }
    }
}
