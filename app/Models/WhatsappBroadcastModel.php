<?php

namespace App\Models;

use App\Enums\MessagesStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WhatsappBroadcastModel extends Model
{
    use HasFactory;

    protected $table = 'broadcast_whatsapp';

    protected $fillable = [
        'broadcast_id',
        'connected_broadcast_id',
        'template_id',
        'template_name',
        'header_file',
        'dynamic_urls',
        'variables',
        'investors_ids',
        'partners_ids',
        'guest_data',
        'register_guest',
        'default_button_response',
        'startup_id',
        'resend_clicked',
        'is_deleted',
        'created_by',
        'updated_by'
    ];

    protected static function booted()
    {
        static::creating(function ($broadcast) {
            $last = self::orderByDesc('id')->first();
            $nextSeq = 1;
            if ($last && preg_match('/WB-[NR]-(\d+)/', $last->broadcast_id, $matches)) {
                $nextSeq = intval($matches[1]) + 1;
            }
            if ($broadcast->connected_broadcast_id) {
                $broadcast->broadcast_id = 'WB-R-' . $nextSeq;
            } else {
                $broadcast->broadcast_id = 'WB-N-' . $nextSeq;
            }
        });
    }

    public function connected(): BelongsTo
    {
        return $this->belongsTo(WhatsappBroadcastModel::class, 'connected_broadcast_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(ReportMessagesWhatsappModel::class, 'broadcast_id', 'id');
    }

    protected $appends = [
        'can_resend',
        'hours_until_resend',
        'recipients_count',
        'pending_count',
        'sent_count',
        'failed_count',
        'delivered_count',
        'seen_count',
        'replied_count'
    ];

    public function getRecipientsCountAttribute()
    {
        $investorsIds = json_decode($this->investors_ids, true) ?? [];
        $partnerIds = json_decode($this->partners_ids, true) ?? [];
        $guestData = json_decode($this->guest_data, true) ?? [];

        return count($investorsIds) + count($partnerIds) + count($guestData);
    }

    public function getRepliedCountAttribute()
    {
        return $this->messages()->where('status', MessagesStatusEnum::replied)->count();
    }

    public function getPendingCountAttribute()
    {
        return $this->messages()->where('status', MessagesStatusEnum::pending)->count();
    }

    public function getSentCountAttribute()
    {
        return $this->messages()->whereIn('status', [
            MessagesStatusEnum::sent,
            MessagesStatusEnum::delivered,
            MessagesStatusEnum::seen,
            MessagesStatusEnum::replied,
        ])->count();
    }

    public function getFailedCountAttribute()
    {
        return $this->messages()->where('status', MessagesStatusEnum::failed)->count();
    }

    public function getDeliveredCountAttribute()
    {
        return $this->messages()->whereIn('status', [
            MessagesStatusEnum::delivered,
            MessagesStatusEnum::seen,
            MessagesStatusEnum::replied,
        ])->count();
    }
    public function getSeenCountAttribute()
    {
        return $this->messages()->whereIn('status', [
            MessagesStatusEnum::seen,
            MessagesStatusEnum::replied,
        ])->count();
    }

    public function getCanResendAttribute()
    {
        // Get the last failed message
        $lastFailedMessage = $this->messages()
            ->where('status', MessagesStatusEnum::failed)
            ->orderByDesc('updated_at') // or 'created_at' depending on when the status is set
            ->first();

        // If no failed messages exist, can't resend
        if (!$lastFailedMessage) {
            return false;
        }

        // Check if 24 hours have passed since the last failed message and resend hasn't been clicked
        return $lastFailedMessage->updated_at &&
            $lastFailedMessage->updated_at->diffInHours(now()) >= 24 &&
            !$this->resend_clicked;
    }

    /**
     * Get hours remaining until resend is available
     */
    public function getHoursUntilResendAttribute()
    {
        // Get the last failed message
        $lastFailedMessage = $this->messages()
            ->where('status', MessagesStatusEnum::failed)
            ->orderByDesc('updated_at')
            ->first();

        if (!$lastFailedMessage || !$lastFailedMessage->updated_at) {
            return '0h 0m';
        }

        $totalMinutesElapsed = $lastFailedMessage->updated_at->diffInMinutes(now());
        $totalMinutesRequired = 24 * 60; // 24 hours in minutes

        if ($totalMinutesElapsed >= $totalMinutesRequired) {
            return '0h 0m';
        }

        $remainingMinutes = $totalMinutesRequired - $totalMinutesElapsed;
        $hours = intval($remainingMinutes / 60);
        $minutes = $remainingMinutes % 60;

        return $hours . 'h ' . $minutes . 'm';
    }

    public function startup(): BelongsTo
    {
        return $this->belongsTo(StartupModel::class, 'startup_id');
    }
}
