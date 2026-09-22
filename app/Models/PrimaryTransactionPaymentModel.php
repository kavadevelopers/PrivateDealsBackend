<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrimaryTransactionPaymentModel extends Model
{
    use HasFactory;

    protected $table = 'primary_transaction_payment';

    protected $fillable = [
        'transaction_id',
        'document_id',
        'type',
        'digio_mandate_id',
        'status',
    ];

    public function primaryTransaction(): BelongsTo
    {
        return $this->belongsTo(PrimaryTransactionModel::class, 'transaction_id');
    }

    public function document(): BelongsTo
    {
        return $this->belongsTo(DocumentsModel::class, 'document_id');
    }
}
