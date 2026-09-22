<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponCompanyModel extends Model
{
    use HasFactory;

    protected $table = 'coupon_company';

    protected $fillable = [
        'coupon_id',
        'company_id',
    ];
}
