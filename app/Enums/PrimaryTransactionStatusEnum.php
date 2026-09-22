<?php

namespace App\Enums;

enum PrimaryTransactionStatusEnum: string
{
    case commitmentpending = 'Commitment Pending';
    case committed = 'Committed';
    case ssasent = 'SSA Sent';
    case ssasigned = 'SSA Signed';
    case mgtcompleted = 'MGT-14 Completed';
    case offerlettersent = 'Offer Letter Sent';
    case offerlettersigned = 'Offer Letter Signed';
    case paymentreceived = 'Payment Received';
    case pasuploaded = 'PAS-3 Uploaded';
    case shasent = 'SHA Sent';
    case completed = 'Completed';
}
