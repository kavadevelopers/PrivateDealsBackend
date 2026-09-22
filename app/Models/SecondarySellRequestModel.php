<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SecondarySellRequestModel extends Model
{
    use HasFactory;

    protected $table = 'secondary_sell_request';

    protected $fillable = [
        'status',
        'instrument',
        'startup_id',
        'portfolio_id',
        'investor_id',
        'shares',
        'price',
        'purchase_price',
        'current_price',
        'last_traded_price'
    ];

    function startup(): BelongsTo
    {
        return $this->belongsTo(StartupModel::class, 'startup_id');
    }

    function investor(): BelongsTo
    {
        return $this->belongsTo(InvestorModel::class, 'investor_id');
    }

    public function transactions()
    {
        return $this->hasMany(SecondaryTransactionModel::class, 'sell_request_id');
    }

    protected $appends = ['current_status', 'available_shares', 'sold_shares', 'percentage','investment_amount','next_step'];

    public function getNextStepAttribute(): string
    {
        switch ($this->status) {
            case 0:
                return 'Waqing for approval from startup';
            case 1:
                return 'Request sent to promoters';
            case 2:
                return 'N/A';
            case 3:
                return 'Waiting for promoters';
            case 4:
                return 'Transaction in process';
            case 5:
                return 'Waiting for existing investor';
            case 6:
                return 'Transaction in process';
            case 7:
                return 'Waiting for investors';
            case 8:
                return 'Transaction in process';
            case 9:
                return 'N/A';
            default:
                return 'Unknown';
        }
    }

    public function getSoldSharesAttribute(): int
    {
        return $this->transactions()->sum('shares');
    }

    public function getInvestmentAmountAttribute(): float
    {
        return $this->shares * $this->price;
    }

    public function getAvailableSharesAttribute(): int
    {
        return $this->shares - $this->sold_shares;
    }

    public function getCurrentStatusAttribute(): string
    {
        switch ($this->status) {
            case 0:
                return 'Pending';
            case 1:
                return 'Approved';
            case 2:
                return 'Rejected';
            case 3:
                return 'Request sent to promoters';
            case 4:
                return 'Request accepted by promoters';
            case 5:
                return 'Request sent to existing investor';
            case 6:
                return 'Request accepted by existing investor';
            case 7:
                return 'Shares listed in secondary market';
            case 8:
                return 'Transaction in process you can check in secondary transactions';
            case 9:
                return 'Sold';
            default:
                return 'Unknown';
        }
    }

    public function getPercentageAttribute()
    {
        return ceil($this->status * 11.11);
    }
}
