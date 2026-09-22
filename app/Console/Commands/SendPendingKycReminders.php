<?php

namespace App\Console\Commands;

use App\Enums\NotificationTypeEnum;
use App\Enums\WpMessageTypeEnum;
use App\Helpers\UtillsHelper;
use App\Models\InvestorModel;
use Illuminate\Console\Command;

class SendPendingKycReminders extends Command
{

    protected $signature = 'app:send-pending-kyc-reminders';
    protected $description = 'Send KYC pending reminder WhatsApp messages after 24 and 48 hours';

    public function handle()
    {
        $investors = InvestorModel::where('is_deleted', 0)
            ->where('preipo_kyc_status', 0)
            ->get();

        foreach ($investors as $investor) {

            if ($investor->is_demo == 1) {
                return;
            }

            $hours = $investor->created_at->diffInHours(now());

            if (!in_array($hours, [24, 48])) {
                continue;
            }

            $params = [$investor->name];

            UtillsHelper::sendWpMessage(
                NotificationTypeEnum::event,
                'kyc_pending_reminder_1_sun',
                WpMessageTypeEnum::text,
                $investor->mobile_number,
                $investor->name,
                null,
                [],
                $params,
                ['investor_id' => $investor->id],
                null,
                true,
                null,
                null,
                $investor->mobile_country_code
            );

            UtillsHelper::sendNotification(
                $investor->id,
                InvestorModel::class,
                'kyc-status',
                'KYC Pending Reminder',
                UtillsHelper::paramsToTemplate(
                    $params,
                    'Reminder: Complete your KYC, by simply uploading your CML. For any assistance related to your account, please contact our support team.'
                )
            );
        }
    }
}
