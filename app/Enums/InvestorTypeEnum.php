<?php

namespace App\Enums;

enum InvestorTypeEnum: string
{
    case individual = 'Individual';
    case hinduundividedfamily = 'Hindu Undivided Family';
    case privatelimited = 'Private Limited';
    case publiclimited = 'Public Limited';
    case partnership = 'Partnership';
    case proprietorship = 'Proprietorship';
    case limitedliabilitypartnership = 'Limited Liability Partnership';
}
