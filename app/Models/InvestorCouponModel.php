<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestorCouponModel extends Model
{
    use HasFactory;

    protected $table = 'investor_coupon';

    protected $fillable = [
        'investor_id',
        'coupon_id',
        'referral_id',
        'display_code',
        'reward_value',
        'status',
        'assigned_at',
        'redeemed_at',
        'redeemed_primary_transaction_id',
        'redeemed_secondary_transaction_id',
        'redeemed_pre_ipo_transaction_id',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'redeemed_at' => 'datetime',
    ];

    public function investor()
    {
        return $this->belongsTo(InvestorModel::class, 'investor_id');
    }

    public function coupon()
    {
        return $this->belongsTo(MasterCouponModel::class, 'coupon_id');
    }

    public function referral()
    {
        return $this->belongsTo(InvestorReferralModel::class, 'referral_id');
    }
}
