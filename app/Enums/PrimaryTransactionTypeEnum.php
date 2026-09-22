<?php

namespace App\Enums;

enum PrimaryTransactionTypeEnum: string
{
    case captable = 'Captable';
    case aif = 'AIF';
}
