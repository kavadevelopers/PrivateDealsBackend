<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SellerCompanySharePriceModel extends Model
{
    protected $table = 'seller_company_share_price';

    protected $fillable = [
        'company_id',
        'seller_id',
        'date',
        'sell_price',
        'buy_price',
        'min_qty',
        'total_qty',
    ];

    protected $hidden = [
        'id',
        'company_id',
        'seller_id',
        'created_at',
        'updated_at',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(CompanyModel::class, 'company_id');
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(SellerMasterModel::class, 'seller_id');
    }
}
