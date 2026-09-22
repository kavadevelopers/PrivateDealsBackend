<?php

namespace App\Enums\Utills;

enum StatusEnum: string
{
    case pending = 'pending';
    case approved = 'approved';
    case rejected = 'rejected';
}
