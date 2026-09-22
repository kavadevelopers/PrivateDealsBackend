<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BonusHistoryModel extends Model
{
    use HasFactory;

    protected $table = 'bonus_history';

    protected $fillable = [
        'company_id',
        'split_ratio',
        'split_date',
        'multiplier',
        'before_split',
        'after_split',
        'affected_portfolios',
        'status',
        'applied_at',
        'reverted_at'
    ];

    protected $casts = [
        'before_split' => 'array',
        'after_split' => 'array',
        'split_date' => 'date',
        'applied_at' => 'datetime',
        'reverted_at' => 'datetime'
    ];

    // Relationship without foreign key constraint
    public function company(): BelongsTo
    {
        return $this->belongsTo(CompanyModel::class, 'company_id', 'id');
    }
}
