<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PreIpoSellRequestModel extends Model
{
    use HasFactory;

    protected $table = 'pre_ipo_sell_requests';

    protected $fillable = [
        'status',
        'company_id',
        'portfolio_id',
        'investor_id',
        'shares',
        'price',
        'purchase_price',
        'current_price',
        'last_traded_price',
        'file'
    ];

    protected $appends = ['current_status', 'next_step'];

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
                return 'Sold';
            default:
                return 'Unknown';
        }
    }

    public function getNextStepAttribute(): string
    {
        switch ($this->status) {
            case 0:
                return 'Waiting For Approval';
            case 1:
                return 'On Market';
            case 2:
                return 'N/A';
            case 3:
                return '-';
            default:
                return 'Unknown';
        }
    }

    function company(): BelongsTo
    {
        return $this->belongsTo(CompanyModel::class, 'company_id');
    }

    function portfolio(): BelongsTo
    {
        return $this->belongsTo(PortfolioPreIpoModel::class);
    }

    function investor(): BelongsTo
    {
        return $this->belongsTo(InvestorModel::class);
    }


    /*
    0 pending 
    1 Approved
    2 Rejected
    3 Sold
    */
}
