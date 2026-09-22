<?php

namespace App\Enums;

enum MessagesStatusEnum: string
{
    case pending = 'pending';
    case sent = 'sent';
    case failed = 'failed';
    case seen = 'seen';
    case delivered = 'delivered';
    case replied = 'replied';
}
