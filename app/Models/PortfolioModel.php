<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PortfolioModel extends Model
{
    use HasFactory;

    protected $table = 'portfolio';

    protected $fillable = [
        'investor_id',
        'startup_id',
        'shares',
        'purchase_price',
        'investment_amount',
        'instrument',
        'is_share_transfered',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'shares' => 'integer',
    ];

    function startup(): BelongsTo
    {
        return $this->belongsTo(StartupModel::class, 'startup_id');
    }

    function investor(): BelongsTo
    {
        return $this->belongsTo(InvestorModel::class, 'investor_id');
    }

    protected $appends = ['current_share_price', 'minimum_shares', 'shares_sold', 'last_traded_price', 'is_primary_transaction', 'is_secondary_transaction', 'on_sell_shares'];

    function getOnSellSharesAttribute(): float
    {
        return SecondarySellRequestModel::where('portfolio_id', $this->id)
            ->wherenotin('status', ['9', '2'])
            ->sum('shares') ?? 0;
    }

    function getIsPrimaryTransactionAttribute(): bool
    {
        return PrimaryTransactionModel::where('portfolio_id', $this->id)->exists();
    }

    function getIsSecondaryTransactionAttribute(): bool
    {
        return SecondaryTransactionModel::where('c_portfolio_id', $this->id)->exists();
    }

    function getSharesSoldAttribute(): int
    {
        return SecondarySellRequestModel::where('instrument', $this->instrument)
            ->where('investor_id', $this->investor_id)
            ->where('portfolio_id', $this->id)
            ->where('status', '!=', '9')
            ->sum('shares') ?? 0;
    }

    function getLastTradedPriceAttribute(): float
    {
        return SecondarySellRequestModel::where('instrument', $this->instrument)
            ->where('startup_id', $this->startup_id)
            ->orderByDesc('id')
            ->first()
            ->price ?? 0;
    }

    function getCurrentSharePriceAttribute(): float|NULL
    {
        return $this->startup->sharePrices->sortByDesc('created_at')->first()->price ?? $this->purchase_price;
    }

    function getMinimumSharesAttribute(): int
    {
        $minSharesFromCaptable = StartupManageCaptableModel::where('startup_id', $this->startup_id)
            ->min('share');

        if (is_null($minSharesFromCaptable)) {
            return PortfolioModel::where('startup_id', $this->startup_id)->min('shares');
        }

        return $minSharesFromCaptable;
    }
}
