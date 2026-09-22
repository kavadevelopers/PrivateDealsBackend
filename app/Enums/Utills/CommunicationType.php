<?php

namespace App\Enums\Utills;

enum CommunicationType: string
{
    case sms = 'sms';
    case email = 'email';
    case whatsapp = 'whatsapp';
}
