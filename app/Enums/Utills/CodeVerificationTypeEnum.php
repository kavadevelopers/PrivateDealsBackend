<?php

namespace App\Enums\Utills;

enum CodeVerificationTypeEnum: string
{
    case register = 'register';
    case forgot_password = 'forget_password';
}
