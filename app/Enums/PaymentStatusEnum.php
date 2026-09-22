<?php

namespace App\Enums;

enum PaymentStatusEnum: string
{
    case pending = 'Pending';
    case completed = 'Completed';
    case rejected = 'Rejected';
    case partialcompleted = 'Partial Completed';
}
