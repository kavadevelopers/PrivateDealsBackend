<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SecondaryPaymentsModel extends Model
{
    use HasFactory;
    protected $table = 'secondary_payments';
    protected $fillable = [
        'transaction_id',
        'document_id',
        'status'
    ];

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(SecondaryTransactionModel::class, 'transaction_id');
    }

    public function document(): BelongsTo
    {
        return $this->belongsTo(DocumentsModel::class, 'document_id');
    }
}
