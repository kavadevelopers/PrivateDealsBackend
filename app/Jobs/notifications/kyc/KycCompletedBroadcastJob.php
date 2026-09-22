<?php

namespace App\Jobs\notifications\kyc;

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

class KycCompletedBroadcastJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $item_id;
    public function __construct($item_id)
    {
        $this->item_id = $item_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $investor = InvestorModel::find($this->item_id);
        if ($investor && $investor->is_demo == 0) {
            $params = [$investor->name];
            UtillsHelper::sendWpMessage(
                NotificationTypeEnum::event,
                'kyc_completed_sun',
                WpMessageTypeEnum::text,
                $investor->mobile_number,
                $investor->name,
                NULL,
                [],
                $params,
                ['investor_id' => $investor->id],
                NULL,
                true,
                NULL,
                NULL,
                $investor->mobile_country_code
            );

            UtillsHelper::sendNotification(
                $investor->id,
                InvestorModel::class,
                'kyc-status',
                'KYC Completed',
                UtillsHelper::paramsToTemplate($params, 'Your KYC verification on PrivateDeals has been successfully completed. Your account is now fully verified, and you can smoothly proceed with transactions. For any assistance related to your account, please contact our support team.')
            );


            $admin = UserAdminModel::where('is_deleted', '0')
                ->where('id', '!=', '1')              // ← exclude super admin
                ->where('id', $investor->perIpoTransactions->updated_by) // ← only the acting manager
                ->first();
            if ($admin && AdminHelper::hasPermission(['cms reports'], $admin->id)) {
                $params = [$admin->name, $investor->name, '+' . $investor->mobile_country_code . '-' . $investor->mobile_number];
                UtillsHelper::sendWpMessage(
                    NotificationTypeEnum::event,
                    'kyc_completed_admin_1_sun',
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
                    'investors',
                    'KYC Completed',
                    // UtillsHelper::paramsToTemplate($params, 'A new user has just registered on the app. Here are the details: 👤 Name: {{2}} 📱 Mobile Number: {{3}}')
                    UtillsHelper::paramsToTemplate($params, 'KYC has been completed for a user on PrivateDeals. Name: {{2}} Ph. No: {{3}} Thank You.')
                );
            }
        }
    }
}
