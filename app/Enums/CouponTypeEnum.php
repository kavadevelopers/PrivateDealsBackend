<?php

namespace App\Enums;

enum CouponTypeEnum: string
{
    case flatdiscount       = 'Flat Discount';
    case percentagediscount = 'Percentage Discount';
    case persharediscount   = 'Per Share Discount';
    case cashback           = 'Cashback';
    case grabopportunity    = 'Grab Opportunity';
}
