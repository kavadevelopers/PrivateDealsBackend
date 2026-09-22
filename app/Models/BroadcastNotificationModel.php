<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BroadcastNotificationModel extends Model
{
    use HasFactory;

    protected $table = 'broadcast_notification';

    protected $fillable = [
        'title',
        'body',
        'image',
        'investors_ids',
        'partners_ids',
        'is_deleted',
        'send_to',
        'topic',
        'data',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'data' => 'array',
    ];
}
