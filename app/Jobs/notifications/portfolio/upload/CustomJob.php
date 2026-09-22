<?php

namespace App\Jobs\notifications\portfolio\upload;

use App\Enums\NotificationTypeEnum;
use App\Enums\WpMessageTypeEnum;
use App\Helpers\AdminHelper;
use App\Helpers\UtillsHelper;
use App\Models\PortfolioImportModel;
use App\Models\UserAdminModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CustomJob implements ShouldQueue
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
        $item = PortfolioImportModel::find($this->item_id);
        if ($item) {
            $admins = UserAdminModel::where('is_deleted', '0')->where('id', '!=', '1')->get();
            foreach ($admins as $key => $admin) {
                if (AdminHelper::hasPermission(['cms reports'], $admin->id)) {
                    $loginUrl = UtillsHelper::tokenUrlGenerate('admin_investor_portfolio_upload', ['is_custom' => true, 'admin_id' => $admin->id, 'investor_uuid' => $item->investor->uuid]);
                    $params = [$admin->name, 'custom', $item->investor->name ?? 'N/A', $item->other_name, $item->shares, $item->share_price];
                    UtillsHelper::sendWpMessage(
                        NotificationTypeEnum::event,
                        'investor_portfolio_upload_admin',
                        WpMessageTypeEnum::text,
                        $admin->mobile_no,
                        $admin->name,
                        NULL,
                        [$loginUrl],
                        $params
                    );

                    UtillsHelper::sendNotification(
                        $admin->id,
                        UserAdminModel::class,
                        'porfolio-upload-request',
                        'Investor portfolio upload',
                        UtillsHelper::paramsToTemplate($params, 'An investor has uploaded a new portfolio to the application. Please check your account for more details. Portfolio Details: 🗂 Portfolio Type: {{2}} 👤 Investor Name: {{3}} 🏢 Startup/Company: {{4}} 📊 No. of Shares: {{5}} 💸 Share Price: ₹{{6}} Kindly review and proceed with the verification process.')
                    );
                }
            }
        }
    }
}
