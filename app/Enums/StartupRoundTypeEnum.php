<?php

namespace App\Enums;

enum StartupRoundTypeEnum: string
{
    case primary = 'Primary Round';
    case aif = 'AIF';
    case secondary = 'Secondary Round';
}
