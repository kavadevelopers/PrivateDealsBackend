<?php

namespace App\Models;

use App\Enums\CompanyEnquiryStatusEnum;
use App\Enums\CompanyEnquiryTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;

class CompanyEnquiryModel extends Model
{
    protected $table = 'company_enquiries';

    protected $fillable = [
        'uuid',
        'company_id',
        'deal_id',
        'enquiry_type',
        'user_id',
        'user_type',
        'quantity',
        'offer_price',
        'offer_valid_till',
        'notes',
        'status',
        'is_deleted',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'offer_price' => 'float',
        'offer_valid_till' => 'date',
        'is_deleted' => 'boolean',
        'enquiry_type' => CompanyEnquiryTypeEnum::class,
        'status' => CompanyEnquiryStatusEnum::class,
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($query) {
            $query->uuid = (string) Str::uuid();
        });
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(CompanyModel::class, 'company_id');
    }

    public function deal(): BelongsTo
    {
        return $this->belongsTo(CompanyDealModel::class, 'deal_id');
    }

    public function user(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'user_type', 'user_id');
    }

    public function scopeNotDeleted($query)
    {
        return $query->where('is_deleted', false);
    }

    public function scopePending($query)
    {
        return $query->where('status', CompanyEnquiryStatusEnum::pending->value);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', CompanyEnquiryStatusEnum::completed->value);
    }
}
