<?php

namespace App\Enums;

enum WpMessageTypeEnum: string
{
    case media = 'media';
    case text = 'text';
    case image = 'image';
}
