<?php

namespace App\Helpers;

use App\Enums\NotificationTypeEnum;
use App\Enums\WpMessageTypeEnum;
use App\Models\InvestorModel;
use App\Traits\WhatsAppSendTrait;

class WhatsAppMessagesHelper
{
    use WhatsAppSendTrait;


    // AIF Onboard Management 
    static function aifOnboardPPMSent(InvestorModel $investor, $PPMLink): void
    {
        if ($PPMLink != null && $investor != null) {
            self::sendWpMessageTrait(
                NotificationTypeEnum::event,
                'aif_onboard_ppm_sign',
                WpMessageTypeEnum::text,
                $investor->mobile_number,
                $investor->name,
                NULL,
                [$PPMLink],
                [$investor->name]
            );

            UtillsHelper::sendNotification(
                $investor->id,
                InvestorModel::class,
                'aif-onboard-ppm',
                'PPM - Aif onboard',
                'Your AIF onboarding process has been initiated. Please review and sign the PPM document to complete your registration. Check your WhatsApp To sign document.'
            );
        }
    }

    static function aifOnboardCASent(InvestorModel $investor, $CALink): void
    {
        if ($CALink != null && $investor != null) {
            self::sendWpMessageTrait(
                NotificationTypeEnum::event,
                'aif_onboard_ca_sign',
                WpMessageTypeEnum::text,
                $investor->mobile_number,
                $investor->name,
                NULL,
                [$CALink],
                [$investor->name]
            );

            UtillsHelper::sendNotification(
                $investor->id,
                InvestorModel::class,
                'aif-onboard-ca',
                'CA - Aif onboard',
                'Your AIF onboarding process has been initiated. Please review and sign the CA document to complete your registration. Check your WhatsApp To sign document.'
            );
        }
    }

    static function aifOnboardSigned(InvestorModel $investor): void
    {
        if ($investor != null) {
            self::sendWpMessageTrait(
                NotificationTypeEnum::event,
                'aif_onboard_complete',
                WpMessageTypeEnum::text,
                $investor->mobile_number,
                $investor->name,
                NULL,
                [],
                [$investor->name]
            );

            UtillsHelper::sendNotification(
                $investor->id,
                InvestorModel::class,
                'aif-onboard-completed',
                'Aif onboard Completed',
                'Your AIF onboarding documents, including PPM and CA, have been successfully signed.'
            );
        }
    }
}
