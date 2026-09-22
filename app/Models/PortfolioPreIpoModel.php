<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PortfolioPreIpoModel extends Model
{
    use HasFactory;

    protected $table = 'portfolio_preipo';

    protected $fillable = [
        'investor_id',
        'company_id',
        'shares',
        'purchase_price',
        'investment_amount',
        'instrument',
        'is_share_transfered',
        'created_by',
        'updated_by',
    ];

    protected $appends = ['current_share_price', 'shares_sold', 'last_traded_price', 'on_sell_shares'];

    function getOnSellSharesAttribute(): float
    {
        return PreIpoSellRequestModel::where('portfolio_id', $this->id)
            ->wherenotin('status', ['3', '2'])
            ->sum('shares') ?? 0;
    }

    function company(): BelongsTo
    {
        return $this->belongsTo(CompanyModel::class, 'company_id');
    }

    function investor(): BelongsTo
    {
        return $this->belongsTo(InvestorModel::class, 'investor_id');
    }

    function getSharesSoldAttribute(): int
    {
        return PreIpoSellRequestModel::where('investor_id', $this->investor_id)
            ->where('portfolio_id', $this->id)
            ->where('status', '!=', '3')
            ->sum('shares') ?? 0;
    }

    function getLastTradedPriceAttribute(): float
    {
        return PreIpoModel::where('company_id', $this->company_id)
            ->orderByDesc('id')
            ->first()
            ->share_price ?? 0;
    }

    function getCurrentSharePriceAttribute(): float|NULL
    {
        // return $this->company->sharePrices->sortByDesc('created_at')->first()->price ?? $this->purchase_price;
        return $this->company->share_price ?? $this->purchase_price;
    }
}
