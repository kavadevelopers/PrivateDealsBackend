<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestAccessParameterModel extends Model
{
    use HasFactory;

    protected $table = 'request_access_parameter';

    protected $fillable = [
        'name',
        'email',
        'mobile',
        'firm_name',
        'device_type',
        'ip_address',
    ];
}
