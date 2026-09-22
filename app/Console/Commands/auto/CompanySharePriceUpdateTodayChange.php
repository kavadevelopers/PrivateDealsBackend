<?php

namespace App\Console\Commands\auto;

use App\Models\CompanyModel;
use Illuminate\Console\Command;

class CompanySharePriceUpdateTodayChange extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:company-share-price-update-today-change';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset company.price_updated_today and company.is_price_updated_today to 0 for the new day.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        CompanyModel::query()->update([
            'price_updated_today' => 0,
            'is_price_updated_today' => 0,
        ]);
    }
}
