<?php

namespace App\Jobs;

use App\Enums\NotificationTypeEnum;
use App\Enums\WpMessageTypeEnum;
use App\Helpers\AdminHelper;
use App\Helpers\UtillsHelper;
use App\Models\InvestorModel;
use App\Models\UserAdminModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendPendingKycAdminNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

    protected $investor;
    public function __construct(InvestorModel $investor)
    {
        $this->investor = $investor;
    }

    public function handle()
    {
        $admins = UserAdminModel::where('is_deleted', 0)
            ->where('id', '!=', 1)
            ->get();

        foreach ($admins as $admin) {

            if (AdminHelper::hasPermission(['investor kyc'], $admin->id)) {

                $params = [
                    $admin->name,
                    $this->investor->name,
                    '+' . $this->investor->mobile_country_code . '-' . $this->investor->mobile_number
                ];

                UtillsHelper::sendWpMessage(
                    NotificationTypeEnum::event,
                    'admin_kyc_pending_notification_sun',
                    WpMessageTypeEnum::text,
                    $admin->mobile_no,
                    $admin->name,
                    NULL,
                    [],
                    $params
                );

                UtillsHelper::sendNotification(
                    $admin->id,
                    UserAdminModel::class,
                    'investor-kyc',
                    'Investor KYC Pending',
                    UtillsHelper::paramsToTemplate(
                        $params,
                        'A new investor KYC request requires verification. Investor Name: {{2}} Mobile Number: {{3}} Please review the KYC documents and take the necessary action.'
                    )
                );
            }
        }
    }
}
