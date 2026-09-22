<?php

namespace App\Enums\Utills;

enum DeviceTypeEnum: string
{
    case web = 'web';
    case android = 'android';
    case ios = 'ios';
    case desktop = 'desktop';
    case macos = 'macos';
}
