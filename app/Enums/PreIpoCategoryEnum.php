<?php

namespace App\Enums;

enum PreIpoCategoryEnum: string
{
    case trending = 'Trending';
    case coming_soon = 'Coming Soon';
    case exclusive_deals = 'Exclusive Deals';
    case listed = 'Listed';
    case liquid_stocks = 'Liquid Stocks';
    case drhp = 'DRHP';
}
