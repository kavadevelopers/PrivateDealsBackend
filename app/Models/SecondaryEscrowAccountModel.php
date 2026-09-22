<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecondaryEscrowAccountModel extends Model
{
    use HasFactory;
    protected $table = 'secondary_escrow_account';
    protected $fillable = [
        'transaction_id',
        'account_id',
        'status',
        'bank',
        'account_no',
        'ifsc_code',
        'balance',
        'validity',
        'start_date',
        'end_date'
    ];
}
