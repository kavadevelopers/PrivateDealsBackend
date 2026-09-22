<?php

namespace App\Console\Commands;

use App\Models\PreIpoModel;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GeneratePreIpoTransactionNumbers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'preipo:generate-transaction-numbers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate masked TN numbers for old Pre-IPO transactions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $counter = 0;

        PreIpoModel::whereNull('transaction_invoice_no')
            ->orderBy('id')
            ->chunk(100, function ($transactions) use (&$counter) {

                foreach ($transactions as $transaction) {

                    $counter++;

                    // Format number
                    $formattedNumber = $counter < 10
                        ? str_pad($counter, 2, '0', STR_PAD_LEFT)
                        : $counter;

                    // Random mask
                    $suffix = strtoupper(Str::random(2));

                    $transaction->transaction_invoice_no =
                        "TN-{$formattedNumber}-{$suffix}";

                    $transaction->save();
                }
            });

        $this->info('Transaction numbers generated successfully.');
    }
}
