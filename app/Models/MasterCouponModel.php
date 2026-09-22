<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MasterCouponModel extends Model
{
    use HasFactory;

    protected $table = 'master_coupon';

    protected $fillable = [
        'uuid',
        'code',
        'type',
        'description',
        'terms_conditions',
        'discount_value',
        'max_discount_amount',
        'applies_on',
        'company_id',
        'startup_id',
        'min_investment_amount',
        'usage_limit_per_user',
        'usage_limit_global',
        'valid_from',
        'valid_to',
        'is_active',
        'is_private',
        'is_deleted',
        'created_via',
        'is_referral_coupon',
        'assign_to_referrer',
        'assign_to_referred',
        'referrer_reward_value',
        'referred_reward_value',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
        'valid_from' => 'datetime',
        'valid_to' => 'datetime',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($coupon) {
            if (empty($coupon->uuid)) {
                $coupon->uuid = (string) Str::uuid();
            }
            // Ensure meta is always an array
            if (is_string($coupon->meta)) {
                $coupon->meta = json_decode($coupon->meta, true) ?? [];
            }
            if (!is_array($coupon->meta)) {
                $coupon->meta = [];
            }
        });

        static::updating(function ($coupon) {
            // Ensure meta is always an array when updating
            if (is_string($coupon->meta)) {
                $coupon->meta = json_decode($coupon->meta, true) ?? [];
            }
            if (!is_array($coupon->meta)) {
                $coupon->meta = [];
            }
        });
    }

    public function investorCoupons()
    {
        return $this->hasMany(InvestorCouponModel::class, 'coupon_id');
    }

    public function company()
    {
        return $this->belongsTo(CompanyModel::class, 'company_id');
    }

    public function companies()
    {
        return $this->belongsToMany(CompanyModel::class, 'coupon_company', 'coupon_id', 'company_id')->withTimestamps();
    }
}
