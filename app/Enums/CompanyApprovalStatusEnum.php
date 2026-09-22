<?php

namespace App\Enums;

enum CompanyApprovalStatusEnum: string
{
    case pending = 'pending';
    case rejected = 'rejected';
    case approved = 'approved';
}
