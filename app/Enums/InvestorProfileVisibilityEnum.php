<?php

namespace App\Enums;

enum InvestorProfileVisibilityEnum: string
{
    case public = 'Public';
    case nameonly = 'Name Only';
    case Private = 'Private';
}
