<?php

namespace App\Jobs\preipo;

use App\Models\CompanyModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CalcuatePricingAutoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public function __construct() {}


    public function handle(): void
    {
        $companies = CompanyModel::where('is_deleted', '0')->get();
        foreach ($companies as $company) {
            $company->syncPricesFromHistory();
        }
    }
}
