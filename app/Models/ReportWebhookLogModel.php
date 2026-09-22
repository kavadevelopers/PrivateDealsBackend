<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportWebhookLogModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'secret',
        'headers',
        'body'
    ];

    protected $table = 'report_webhook_logs';
}
