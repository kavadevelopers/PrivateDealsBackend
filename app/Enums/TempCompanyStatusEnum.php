<?php

namespace App\Enums;

enum TempCompanyStatusEnum: string
{
    case pending = 'pending';
    case rejected = 'rejected';
    case approved = 'approved';
}
