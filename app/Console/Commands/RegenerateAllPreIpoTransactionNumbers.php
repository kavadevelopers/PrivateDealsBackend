<?php

namespace App\Console\Commands;

use App\Models\PreIpoModel;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class RegenerateAllPreIpoTransactionNumbers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'preipo:regenerate-all-tn';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Force regenerate TN numbers for ALL Pre-IPO transactions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $counter = 0;

        PreIpoModel::orderBy('id')
            ->chunk(100, function ($transactions) use (&$counter) {

                foreach ($transactions as $transaction) {

                    $counter++;

                    // Format number (01–09 only)
                    $formattedNumber = $counter < 10
                        ? str_pad($counter, 2, '0', STR_PAD_LEFT)
                        : $counter;

                    // Random suffix
                    $suffix = strtoupper(Str::random(2));

                    // FINAL FORMAT: TN-01-X7
                    $transaction->transaction_invoice_no =
                        "TN-{$formattedNumber}-{$suffix}";

                    // Save quietly (no events)
                    $transaction->saveQuietly();
                }
            });

        $this->info('✅ All transaction invoice numbers regenerated successfully.');
    }
}
