<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyFundamentalsModel extends Model
{
    protected $table = 'company_fundamentals';

    protected $fillable = [
        'company_id',
        'lot_size',
        'fifty_two_week_high',
        'fifty_two_week_low',
        'depository',
        'pan_number',
        'isin_number',
        'cin_number',
        'rta',
        'market_cap',
        'pe_ratio',
        'pb_ratio',
        'debt_to_equity',
        'roe',
        'book_value',
        'face_value',
        'total_shares',
    ];

    protected $hidden = [
        'id',
        'company_id',
        'sector_id',
        'created_at',
        'updated_at'
    ];

    /**
     * Get the company that owns the fundamentals.
     * 
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(CompanyModel::class, 'company_id');
    }

    public function sharePrices()
    {
        return $this->hasMany(CompanySharePriceModel::class, 'company_id', 'company_id');
    }

    // protected ?float $_cachedFiftyTwoWeekHigh = 0;
    // protected ?float $_cachedFiftyTwoWeekLow = 0;

    // protected function fiftyTwoWeekHigh(): Attribute
    // {
    //     return Attribute::get(function () {
    //         if ($this->_cachedFiftyTwoWeekHigh === null) {
    //             $maxPrice = $this->sharePrices()
    //                 ->where('date', '>=', now()->subWeeks(52))
    //                 ->max('price');

    //             $this->_cachedFiftyTwoWeekHigh = $maxPrice !== null ? round((float) $maxPrice, 2) : 0.00;
    //         }

    //         return $this->_cachedFiftyTwoWeekHigh;
    //     });
    // }

    // protected function fiftyTwoWeekLow(): Attribute
    // {
    //     return Attribute::get(function () {
    //         if ($this->_cachedFiftyTwoWeekLow === null) {
    //             $minPrice = $this->sharePrices()
    //                 ->where('date', '>=', now()->subWeeks(52))
    //                 ->min('price');

    //             $this->_cachedFiftyTwoWeekLow = $minPrice !== null ? round((float) $minPrice, 2) : 0.00;
    //         }

    //         return $this->_cachedFiftyTwoWeekLow;
    //     });
    // }
}
