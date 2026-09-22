<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class StartupFundRaiseModel extends Model
{
    use HasFactory;

    protected $table = 'startup_fund_raise';

    protected $fillable = [
        'round_id',
        'startup_id',
        'fund_requirement',
        'fund_utilisation_details',
        'current_fund_raise',
        'committed_investors',
        'funds_required_from_shuru',
        'min_ticket_size',
        'pre_money_valuati  on',
        'pre_money_valuation_basis',
        'instrument_and_conversion_condition',
        'prev_fund_raised_date',                  // New column
        'prev_fund_raise_investor_name',                // New column
        'previous_fund_raised_amount',  // New column
        'valuation_of_previous_round'  // New columns

    ];

    public function startup(): HasOne
    {
        return $this->hasOne(StartupModel::class, 'startup_id','id');
    }

    public function StartupRound(): BelongsTo
    {
        return $this->belongsTo(StartupRoundModel::class, 'round_id');
    }
}
