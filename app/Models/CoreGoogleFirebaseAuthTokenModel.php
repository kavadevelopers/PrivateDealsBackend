<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoreGoogleFirebaseAuthTokenModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'token',
        'expired_at'
    ];

    protected $table = 'core_google_firebase_auth_token';
}
