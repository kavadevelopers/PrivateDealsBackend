<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StartupFinancialDetailModel extends Model
{
    use HasFactory;

    protected $table = 'startup_financial_details';

    protected $fillable = [
        'startup_id',
        'round_id',
        'year',
        'net_revenue',
        'ebitda',
        'pat',
        'raised_date',
        'investor_name',
        'previous_fund_raised_amount',
        'valuation_of_previous_round',
        'revenue_expected',
        'current_fy_closing_expense',
        'current_fy_closing_ebitda',
        'current_fy_closing_pat',
        'next_fy_revenue',
        'next_fy_expense',
        'next_fy_ebitda',
        'next_fy_pat',
    ];

    public function startup():BelongsTo
    {
        return $this->belongsTo(StartupModel::class);
    }

    public function round():BelongsTo
    {
        return $this->belongsTo(StartupRoundModel::class);
    }
}

