<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StartupSharePriceModel extends Model
{
    use HasFactory;

    protected $table = 'startup_share_price';

    protected $fillable = [
        'startup_id',
        'mis_id',
        'price',
    ];

    protected $casts = [
        'price' => 'integer',
    ];

    public function startup(): BelongsTo
    {
        return $this->belongsTo(StartupModel::class, 'startup_id');
    }

    public function mis(): BelongsTo
    {
        return $this->belongsTo(StartupMisModel::class, 'mis_id');
    }

    public function getPriceAttribute($value)
    {
        return (int) $value;  // Cast the 'price' value to an integer
    }
}
