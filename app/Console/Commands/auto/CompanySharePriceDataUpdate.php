<?php

namespace App\Console\Commands\auto;

use App\Jobs\preipo\CalcuatePricingAutoJob;
use Illuminate\Console\Command;

class CompanySharePriceDataUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:company-share-price-data-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        CalcuatePricingAutoJob::dispatch();
    }
}
