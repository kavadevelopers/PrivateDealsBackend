<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecondaryShareTransferModel extends Model
{
    use HasFactory;
    protected $table = 'secondary_share_transfer';
    protected $fillable = [
        'transaction_id',
        'document_id',
        'status'
    ];
}
