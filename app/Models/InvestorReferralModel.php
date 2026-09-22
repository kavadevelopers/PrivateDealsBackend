<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestorReferralModel extends Model
{
    use HasFactory;

    protected $table = 'investor_referral';

    protected $fillable = [
        'referrer_investor_id',
        'referral_code',
        'referred_investor_id',
        'status',
        'referrer_coupon_id',
        'referred_coupon_id',
    ];

    public function referrer()
    {
        return $this->belongsTo(InvestorModel::class, 'referrer_investor_id');
    }

    public function referred()
    {
        return $this->belongsTo(InvestorModel::class, 'referred_investor_id');
    }

    public function referrerCoupon()
    {
        return $this->belongsTo(InvestorCouponModel::class, 'referrer_coupon_id');
    }

    public function referredCoupon()
    {
        return $this->belongsTo(InvestorCouponModel::class, 'referred_coupon_id');
    }
}
