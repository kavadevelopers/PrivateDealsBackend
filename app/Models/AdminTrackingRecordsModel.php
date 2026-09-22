<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AdminTrackingRecordsModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type_id',
        'type',
        'description'
    ];

    protected $table = 'admin_tracking_records';
}
