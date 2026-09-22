<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportMessagesSMSModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'trycount',
        'type',
        'status',
        'response_code',
        'response',
        'destination_mobile_no',
        'message_data',
        'body',
        'url'
    ];

    protected $table = 'report_messages_sms';
}
