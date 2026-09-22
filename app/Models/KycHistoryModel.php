<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KycHistoryModel extends Model
{
    use HasFactory;

    protected $table = 'kyc_history';

    protected $fillable = [
        'user_type',
        'user_id',
        'reference_type',
        'reference_id',
        'created_by_type',
        'created_by_id',
        'notes',
    ];
}
