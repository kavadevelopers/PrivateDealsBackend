<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;


class StartupKeyMetricsModel extends Model
{
    use HasFactory;

    protected $table = 'startup_key_metrics';

    protected $fillable = [
        'round_id',
        'startup_id',
        'founder_capital_contribution',
        'monthly_revenue_run_rate',
        'annualized_revenue_run_rate',
        'traction_metrics',
        'current_monthly_burn',
        'current_cash_balance',
        'runway_months',
        'competitors',
        'key_usp_differentiator_entry_barrier',
    ];

    public function startup(): HasOne
    {
        return $this->hasOne(StartupModel::class, 'startup_id','id');
    }
}
