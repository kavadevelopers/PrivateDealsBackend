<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReportMessagesWhatsappModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'message_id',
        'broadcast_id',
        'reference_id',
        'reference_model',
        'template_name',
        'template_type',
        'trycount',
        'status',
        'response_code',
        'response',
        'mobile_country_code',
        'destination_mobile_no',
        'username',
        'media',
        'message_data',
        'params',
        'click_url',
        'type'
    ];

    protected $table = 'report_messages_whatsapp';

    public function replies(): HasMany
    {
        return $this->hasMany(ReportMessagesWhatsappRepliesModel::class, 'whatsapp_message_id');
    }

    public function broadcast(): BelongsTo
    {
        return $this->belongsTo(WhatsappBroadcastModel::class, 'broadcast_id', 'id');
    }
}
