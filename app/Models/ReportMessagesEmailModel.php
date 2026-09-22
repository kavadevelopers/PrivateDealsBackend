<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportMessagesEmailModel extends Model
{
    use HasFactory;

    protected $table = 'report_messages_email';

    protected $fillable = [
        'trycount',
        'type',
        'status',
        'response_code',
        'response',
        'subject',
        'destination_emails',
        'body',
        'attachments',
    ];
}
