<?php

namespace App\Jobs\backend\auth;

use App\Enums\NotificationTypeEnum;
use App\Enums\WpMessageTypeEnum;
use App\Helpers\UtillsHelper;
use App\Models\InvestorModel;
use App\Models\InvestorRegisterRequestModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RequestAceessApproveJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
        $requestAccess = InvestorRegisterRequestModel::find($this->item_id);
        if ($requestAccess && $requestAccess->is_readed == 0) {
            $requestAccess->is_readed = 1;
            $requestAccess->save();
            if ($requestAccess->is_startup) {
                $investor = InvestorModel::find($requestAccess->user_id);
                if ($investor) {
                    $investor->is_primary_access = 1;
                    $investor->is_secondary_access = 1;
                    $investor->save();

                    $params = [$investor->name];
                    UtillsHelper::sendWpMessage(
                        NotificationTypeEnum::event,
                        'given_startup_access',
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
                        'startup_home',
                        'Startup Access Granted',
                        UtillsHelper::paramsToTemplate($params, 'We’ve granted you access to the **Startup section** of the app. You can now explore exclusive startup investment opportunities and discover promising early-stage companies. Start exploring and make your next big move! 💼🚀'),
                        ['redirect_to' => 'home/primary'],
                    );
                }
            }
        }
    }
}
