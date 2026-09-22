<?php

namespace App\Console\Commands;

use App\Enums\AdminTypeEnum;
use App\Enums\NotificationTypeEnum;
use App\Enums\WpMessageTypeEnum;
use App\Helpers\AdminHelper;
use App\Helpers\DateTimeHelper;
use App\Helpers\UtillsHelper;
use App\Models\ResourceBillingModel;
use App\Models\UserAdminModel;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendRenewalReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:renewal-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders to users whose renewal date is within a week';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $oneWeekLater = Carbon::now()->addWeek();
        $currentDate = Carbon::now();
        $resources = ResourceBillingModel::where('renewal_date', '<=', $oneWeekLater)
            ->where('renewal_date', '>=', $currentDate)
            ->get();

        // $this->info('Today Date' . $currentDate);
        // $this->info('Week Date' . $oneWeekLater);

        foreach ($resources as $resource) {
            $admins = UserAdminModel::where('is_deleted', '0')->where('role', AdminTypeEnum::tech->value)->get();
            foreach ($admins as $key => $admin) {
                UtillsHelper::sendWpMessage(NotificationTypeEnum::regular, 'subscription_expire', WpMessageTypeEnum::text, $admin->mobile_no, $admin->name, NULL, [], [
                    $admin->name,
                    $resource->resource_type,
                    $resource->projects->project_name ?? 'N/A',
                    DateTimeHelper::viewDate($resource->renewal_date),
                ]);
            }
        }
    }
}
