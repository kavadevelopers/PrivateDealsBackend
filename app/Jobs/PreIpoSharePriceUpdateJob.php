<?php

namespace App\Jobs;

use App\Jobs\preipo\CalcuatePricingAutoJob;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\CompanyDailySharePriceModel;
use App\Models\CompanyModel;
use App\Models\CompanySharePriceModel;
use Illuminate\Support\Facades\Log;

class PreIpoSharePriceUpdateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected array $recordIds;
    protected array $companyIds;

    public function __construct(array $recordIds, array $companyIds)
    {
        $this->recordIds = $recordIds;
        $this->companyIds = $companyIds;
    }


    public function handle(): void
    {
        // Log::debug('In Job');
        $companies = CompanyModel::where('is_deleted', '0')->whereIn('id', $this->companyIds)->get();
        foreach ($companies as $key => $value) {
            // Log::debug('Company ' . $value->id);
            $wmPrice = 0;
            $todayMinPrice = CompanyDailySharePriceModel::getMinPriceFromArray($value->id, $this->recordIds, 'distributor_price');
            if ($todayMinPrice > 0) {
                $wmPrice = $todayMinPrice;
            } else {
                $oldPrice = CompanySharePriceModel::select('distributer_price')->where('company_id', $value->id)
                    ->orderBy('date', 'desc')
                    ->first();
                if (!$oldPrice) {
                    $wmPrice = 0;
                } else {
                    $wmPrice = $oldPrice->distributer_price;
                }
            }

            $todayMinPrice = CompanyDailySharePriceModel::getMinPriceFromArray($value->id, $this->recordIds, 'retailer_price');
            if ($todayMinPrice > 0) {
                $retailerPrice = $todayMinPrice;
            } else {
                $oldPrice = CompanySharePriceModel::select('price')->where('company_id', $value->id)
                    ->orderBy('date', 'desc')
                    ->first();
                if (!$oldPrice) {
                    $retailerPrice = 0;
                } else {
                    $retailerPrice = $oldPrice->price;
                }
            }
            $todayMinPrice = CompanyDailySharePriceModel::getMinPriceFromArray($value->id, $this->recordIds, 'price');
            if ($todayMinPrice > 0) {
                $basePrice = $todayMinPrice;
            } else {
                $oldPrice = CompanySharePriceModel::select('base_price')->where('company_id', $value->id)
                    ->orderBy('date', 'desc')
                    ->first();
                if (!$oldPrice) {
                    $basePrice = 0;
                } else {
                    $basePrice = $oldPrice->base_price;
                }
            }

            // CompanySharePriceModel::where('date', $this->date)->where('company_id', $value->id)->delete();
            CompanySharePriceModel::create([
                'company_id'                => $value->id,
                'date'                      => date('Y-m-d'),
                'price'                     => $retailerPrice,
                'distributer_price'         => $wmPrice,
                'base_price'                => $basePrice
            ]);
        }
        CalcuatePricingAutoJob::dispatch();
    }
}
