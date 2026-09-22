<?php

namespace App\Enums;

enum AdminTypeEnum: string
{
    case admin = 'admin';
    case manager = 'manager';
    case founder = 'founder';
    case tech = 'tech';
}
