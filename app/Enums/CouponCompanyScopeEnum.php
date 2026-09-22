<?php

namespace App\Enums;

enum CouponCompanyScopeEnum: string
{
    case all = 'All';
    case multiple = 'Multiple';
    case single = 'Single';
}
