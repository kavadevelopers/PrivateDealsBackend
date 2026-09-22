<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanySharePriceModel extends Model
{
    protected $table = 'company_share_price';

    protected $fillable = [
        'company_id',
        'date',
        'price',
        'base_price',
        'distributer_price'
    ];

    protected $hidden = [
        'id',
        'company_id',
        'created_at',
        'updated_at'
    ];

    /**
     * Get the company that owns the share price.
     * 
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(CompanyModel::class, 'company_id');
    }
}
