<?php

namespace App\Enums;

enum CompanyDealStatusEnum: string
{
    case available = 'available';
    case half_sold = 'half_sold';
    case sold = 'sold';
}
