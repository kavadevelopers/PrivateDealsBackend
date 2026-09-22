<?php

namespace App\Enums;

enum PrimaryTransactionPaymentMode: string
{
    case rtgs = 'RTGS';
    case cheque = 'Cheque';
    case mandate = 'Mandate';
}
