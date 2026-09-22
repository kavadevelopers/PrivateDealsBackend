<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyPromotersModel extends Model
{
    protected $table = 'company_promoters';

    protected $fillable = [
        'company_id',
        'name',
        'designation',
        'experience',
        'url',
    ];

    protected $hidden = [
        'id',
        'company_id',
        'created_at',
        'updated_at'
    ];

    /**
     * Get the company that owns the promoters.
     * 
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(CompanyModel::class, 'company_id');
    }
}
