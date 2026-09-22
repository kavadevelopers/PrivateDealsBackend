<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportMessagesWhatsappRepliesModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'whatsapp_message_id',
        'message'
    ];

    protected $table = 'report_messages_whatsapp_replies';
}
