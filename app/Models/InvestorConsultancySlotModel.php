<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvestorConsultancySlotModel extends Model
{
    use HasFactory;

    protected $table = 'investor_consultancy_slots';

    protected $fillable = [
        'investor_id',
        'calendly_event_uri',
        'calendly_invitee_uri',
        'calendly_meeting_url',
        'scheduled_start_time',
        'scheduled_end_time',
        'calendly_event_data',
        'first_name',
        'last_name',
        'email',
        'description',
        'mobile_number',
        'mobile_country_code',
        'status',
    ];

    protected $casts = [
        'scheduled_start_time' => 'datetime',
        'scheduled_end_time' => 'datetime',
        'calendly_event_data' => 'array',
    ];

    public function investor(): BelongsTo
    {
        return $this->belongsTo(InvestorModel::class, 'investor_id');
    }
}
