<?php

namespace App\Enums;

enum HolidayTypeEnum: string
{
    case national = 'National Holiday';
    case regional = 'Regional Holiday';
    case market_closure = 'Market Closure';
    case special = 'Special Holiday';
}
