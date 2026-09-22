<?php

namespace App\Helpers;

use App\Enums\NotificationTypeEnum;
use App\Models\ReportsVerificationCodeModel;
use App\Traits\SMSSendTrait;

class SMSHelper
{
    use SMSSendTrait;

    static function sendVerificationCode(string $code, string $item_id, string $mobile_no): void
    {
        $body = 'Hello There, ' . $code . ' is the OTP on Shuru-up';
        $data = [
            'class' => ReportsVerificationCodeModel::class,
            'id'    => $item_id
        ];
        self::sendSms(NotificationTypeEnum::event, $mobile_no, $body, $data);
    }
}
