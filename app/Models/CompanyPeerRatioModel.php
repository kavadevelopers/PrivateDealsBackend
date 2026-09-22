<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyPeerRatioModel extends Model
{
    use HasFactory;

    protected $table = 'company_peer_ratio';

    protected $fillable = [
        'company_id',
        'perticular',
        'revenue',
        'eps',
        'market_cap',
        'pe',
    ];

    protected $hidden = [
        'id',
        'company_id',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'perticular' => 'string',
        'pe' => 'string'
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
