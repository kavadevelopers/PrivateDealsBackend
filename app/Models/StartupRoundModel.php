<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StartupRoundModel extends Model
{
    use HasFactory;

    protected $table = 'startup_round';

    protected $fillable = [
        'startup_id',
        'name',
        'round_type',
        'round_status',
        'share_price',
        'shuru_commission',
        'instrument',
        'floor',
        'cap',
        'equity_offered',
        'minimum_investment',
        'minimum_investment_aif',
        'total_fund_requirement',
        'fund_requirement',
        'is_deleted',
        'created_by',
        'updated_by',
    ];

    public function pitches(): HasMany
    {
        return $this->hasMany(StartupPitchModel::class, 'startup_round_id');
    }

    public function startup(): BelongsTo
    {
        return $this->belongsTo(StartupModel::class, 'startup_id');
    }

    public function primary_transactions()
    {
        return $this->hasMany(PrimaryTransactionModel::class, 'round_id', 'id');
    }
}
