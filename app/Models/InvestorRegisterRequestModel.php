<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestorRegisterRequestModel extends Model
{
    use HasFactory;

    protected $table = 'investor_register_request';

    protected $fillable = [
        'name',
        'mobile_number',
        'mobile_country_code',
        'email',
        'device',
        'apple_email',
        'is_readed',
        'is_converted',
        'notes',
        'is_startup',
        'description',
        'user_id',
        'user_type'
    ];
}
