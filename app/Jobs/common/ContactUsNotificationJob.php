<?php

namespace App\Jobs\common;

use App\Enums\NotificationTypeEnum;
use App\Enums\WpMessageTypeEnum;
use App\Helpers\AdminHelper;
use App\Helpers\UtillsHelper;
use App\Models\CmsContactModel;
use App\Models\InvestorModel;
use App\Models\PartnerModel;
use App\Models\UserAdminModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ContactUsNotificationJob implements ShouldQueue
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
        $item = CmsContactModel::find($this->item_id);
        if ($item) {
            $admins = UserAdminModel::where('is_deleted', '0')->where('id', '!=', '1')->get();
            foreach ($admins as $key => $admin) {
                if (AdminHelper::hasPermission(['cms reports'], $admin->id)) {
                    $usertype = 'From Website Guest';
                    if ($item->user_type == InvestorModel::class) {
                        $usertype = 'From Investor App';
                    }
                    if ($item->user_type == PartnerModel::class) {
                        $usertype = 'From Business App';
                    }
                    $params = [$admin->name, $usertype, $item->firstname, $item->company ?? 'N/A', $item->mobile_no, $item->email, $item->subject, $item->description ?? 'N/A'];
                    UtillsHelper::sendWpMessage(
                        NotificationTypeEnum::event,
                        'contact_us_template',
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
                        'cms-contact',
                        'Contact Request',
                        UtillsHelper::paramsToTemplate($params, 'A new contact form submission has been received. Here are the details: 🔹 User Type: {{2}} 🔹 Name: {{3}} 🔹 Company: {{4}} 🔹 Mobile Number: {{5}} 🔹 Email: {{6}} 🔹 Subject: {{7}} 🔹 Message: {{8}} You can check all the details in your account for further action. Thank you!')
                    );
                }
            }
        }
    }
}
