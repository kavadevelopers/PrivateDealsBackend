<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBankAccountModel extends Model
{
    use HasFactory;

    protected $table = 'user_bank_accounts';

    protected $fillable = [
        'user_type',
        'user_id',
        'account_number',
        'account_holder_name',
        'ifsc_code',
        'bank_name',
        'is_default',
        'status',
    ];

    protected $hidden = [
        'id',
        'user_type',
        'user_id',
        'created_at',
        'updated_at',
        'status'
    ];
}
