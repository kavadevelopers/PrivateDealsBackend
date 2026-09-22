<?php

namespace App\Jobs\notifications\auth;

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

class NewInvestorRegisterJob implements ShouldQueue
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
                'welcome_message',
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
                'home',
                'Registration Successful',
                UtillsHelper::paramsToTemplate($params, 'We confirm that your registration with Shuru-Up has been successfully completed. Your account is now active and available for use. For any assistance related to your account, please contact our support team.')
            );


            $admins = UserAdminModel::where('is_deleted', '0')->where('id', '!=', '1')->get();
            foreach ($admins as $key => $admin) {
                if (AdminHelper::hasPermission(['cms reports'], $admin->id)) {
                    $params = [$admin->name, $investor->name, '+' . $investor->mobile_country_code . '-' . $investor->mobile_number];
                    UtillsHelper::sendWpMessage(
                        NotificationTypeEnum::event,
                        'new_investor_registered_to_admin',
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
                        'New Investor Registration',
                        UtillsHelper::paramsToTemplate($params, 'A new user has just registered on the app. Here are the details: 👤 Name: {{2}} 📱 Mobile Number: {{3}}')
                    );
                }
            }
        }
    }
}
