<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrimaryTransactionPresentationModel extends Model
{
    use HasFactory;

    protected $table = 'primary_transaction_presentation';

    protected $fillable = [
        'mandate_id',
        'presentation_id',
        'transaction_id',
        'amount',
        'status',
        'notes',
    ];
}
