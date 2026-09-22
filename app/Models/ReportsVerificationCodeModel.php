<?php

namespace App\Models;

use App\Enums\Utills\CodeVerificationTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportsVerificationCodeModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_type',
        'notification_type',
        'code',
        'code_type',
        'is_used',
        'expired_at'
    ];

    protected $table = 'reports_verification_codes';
}
