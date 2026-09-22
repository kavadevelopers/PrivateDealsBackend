<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyPriceAlertModel extends Model
{
    use HasFactory;

    protected $table = 'company_price_alerts';

    protected $fillable = [
        'investor_id',
        'company_id',
        'direction',
        'target_price',
        'is_active',
        'is_triggered',
        'triggered_at',
        'remind_always',
    ];

    protected $casts = [
        'is_active'    => 'boolean',
        'is_triggered' => 'boolean',
        'remind_always' => 'boolean',
        'triggered_at' => 'datetime',
    ];

    /**
     * Investor who owns this alert.
     */
    public function investor(): BelongsTo
    {
        return $this->belongsTo(InvestorModel::class, 'investor_id');
    }

    /**
     * Company for which this alert is set.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(CompanyModel::class, 'company_id');
    }
}
