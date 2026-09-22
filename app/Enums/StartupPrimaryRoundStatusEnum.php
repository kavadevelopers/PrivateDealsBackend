<?php

namespace App\Enums;

enum StartupPrimaryRoundStatusEnum: string
{
    case pending = 'Pending';
    case comingsoon = 'Coming Soon';
    case raisingnow = 'Raising Now';
    case completed = 'Completed';
}
