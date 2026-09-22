<?php

namespace App\Enums;

enum ResoureceTypeEnum:string
{
    case SSL = 'ssl';
    case SERVER = 'server';
    case DOMAIN = 'domain';
    case S3 = 's3';
    case APP = 'app';
    case SUBSCRIPTION = 'subscription';

}
