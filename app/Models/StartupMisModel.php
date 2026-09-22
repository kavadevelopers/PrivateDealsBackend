<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Enums\Utills\StatusEnum as UtillsStatusEnum;

class StartupMisModel extends Model
{
    use HasFactory;

    protected $table = 'startup_mis';

    protected $fillable = [
        'startup_id',
        'title',
        'document',
        'description',
        'status',
    ];

    protected $casts = [
        'status' => UtillsStatusEnum::class,
    ];

    public function startup(): BelongsTo
    {
        return $this->belongsTo(StartupModel::class, 'startup_id');
    }

    public function sharePrices(): HasMany
    {
        return $this->hasMany(StartupSharePriceModel::class, 'mis_id');
    }
}
