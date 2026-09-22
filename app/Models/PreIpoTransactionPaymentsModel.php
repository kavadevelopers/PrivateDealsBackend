<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PreIpoTransactionPaymentsModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'status',
        'document_id'
    ];

    protected $table = 'pre_ipo_transaction_payments';

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(PreIpoModel::class, 'transaction_id');
    }

    public function document(): BelongsTo
    {
        return $this->belongsTo(DocumentsModel::class, 'document_id');
    }
}
