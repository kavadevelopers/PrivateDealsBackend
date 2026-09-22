<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportNotificationsModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_type',
        'title',
        'body',
        'image',
        'is_sent',
        'response_code',
        'response',
        'broadcast_id',
        'message_id',
        'data',
        'redirection',
        'is_read',
        'is_posted'
    ];

    // protected $casts = [
    //     'data' => 'array',
    // ];

    protected $table = 'report_notifications';

    public function user()
    {
        return $this->morphTo(__FUNCTION__, 'user_type', 'user_id');
    }
}
