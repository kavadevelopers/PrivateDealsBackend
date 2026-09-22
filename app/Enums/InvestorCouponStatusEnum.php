<?php

namespace App\Enums;

enum InvestorCouponStatusEnum: string
{
    case active    = 'Active';
    case assigned  = 'Assigned';
    case redeemed  = 'Redeemed';
    case expired   = 'Expired';
    case cancelled = 'Cancelled';
}
