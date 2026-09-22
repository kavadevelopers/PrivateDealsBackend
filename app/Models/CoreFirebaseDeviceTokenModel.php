<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoreFirebaseDeviceTokenModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_type',
        'device',
        'device_id',
        'token',
        'version',
    ];

    protected $table = 'core_firebase_device_token';
}
