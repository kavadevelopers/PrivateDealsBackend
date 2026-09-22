<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StartupOfferRequestModel extends Model
{
    use HasFactory;

    protected $table = 'startup_offerrequest';

    protected $fillable = [
        'startup_id',
        'status'
    ];

    public function startup(): BelongsTo
    {
        return $this->belongsTo(StartupModel::class, 'startup_id');
    }
}
