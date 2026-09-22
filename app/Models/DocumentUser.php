<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentUser extends Model
{
    protected $fillable = [
        'document_id',
        'user_id',
        'user_type',
    ];

    public function document(): BelongsTo
    {
        return $this->belongsTo(StartupDocumentModel::class);
    }
}
