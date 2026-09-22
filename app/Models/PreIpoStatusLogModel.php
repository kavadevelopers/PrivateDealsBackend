<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PreIpoStatusLogModel extends Model
{
    protected $table = 'pre_ipo_transaction_status_logs';

    protected $fillable = [
        'transaction_id',
        'status',
    ];

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(PreIpoModel::class, 'transaction_id');
    }
}
