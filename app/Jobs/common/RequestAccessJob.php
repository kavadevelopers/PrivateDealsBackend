<?php

namespace App\Jobs\common;

use App\Enums\NotificationTypeEnum;
use App\Enums\WpMessageTypeEnum;
use App\Helpers\AdminHelper;
use App\Helpers\UtillsHelper;
use App\Models\InvestorRegisterRequestModel;
use App\Models\UserAdminModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RequestAccessJob implements ShouldQueue
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
        $item = InvestorRegisterRequestModel::find($this->item_id);
        if ($item) {
            $admins = UserAdminModel::where('is_deleted', '0')->where('id', '!=', '1')->get();
            foreach ($admins as $key => $admin) {
                if (AdminHelper::hasPermission(['cms reports'], $admin->id)) {
                    $openUrl = UtillsHelper::tokenUrlGenerate('admin_request_access_list', ['admin_uuid' => $admin->uuid]);
                    $approveUrl = UtillsHelper::tokenUrlGenerate('request_access_approve', ['item_id' => $item->id, 'admin_uuid' => $admin->uuid]);
                    $params = [$admin->name, $item->is_startup ? 'Startup' : 'General', $item->name, '+' . $item->mobile_country_code . '-' . $item->mobile_number, $item->email, $item->device];
                    UtillsHelper::sendWpMessage(
                        NotificationTypeEnum::event,
                        'request_access_general_1',
                        WpMessageTypeEnum::text,
                        $admin->mobile_no,
                        $admin->name,
                        NULL,
                        [$openUrl, $approveUrl],
                        $params
                    );

                    UtillsHelper::sendNotification(
                        $admin->id,
                        UserAdminModel::class,
                        'request-access',
                        'Request Access',
                        UtillsHelper::paramsToTemplate($params, 'A new user has requested {{2}}. 👤 Name: {{3}} 📱 Mobile: {{4}} ✉️ Email: {{5}} 💻 Platform: {{6}}')
                    );
                }
            }
        }
    }
}
