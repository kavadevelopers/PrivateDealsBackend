<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvestorFavStartupModel extends Model
{
    use HasFactory;

    protected $table = 'investor_favourite_startup';

    protected $fillable = [
        'startup_id',
        'investor_id',
    ];

    public function investor(): BelongsTo
    {
        return $this->belongsTo(InvestorModel::class, 'investor_id');
    }
    public function startup(): BelongsTo
    {
        return $this->belongsTo(StartupModel::class, 'startup_id');
    }
}

