<?php

namespace App\Console\Commands\reminders;

use App\Enums\AdminTypeEnum;
use App\Enums\NotificationTypeEnum;
use App\Enums\WpMessageTypeEnum;
use App\Helpers\AdminHelper;
use App\Helpers\UtillsHelper;
use App\Models\CompanyDailySharePriceModel;
use App\Models\UserAdminModel;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PrivateEquitySharePrice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:private-equity-share-price-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send message to admin to update private equity share price';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $isPriceAddedToday = CompanyDailySharePriceModel::where('date', Carbon::today())->exists();
        if (!$isPriceAddedToday) {
            $admins = UserAdminModel::where('is_deleted', '0')->get();
            foreach ($admins as $key => $admin) {
                if (AdminHelper::hasPermission(['company'], $admin->id)) {
                    UtillsHelper::sendWpMessage(NotificationTypeEnum::regular, 'reminder_share_price', WpMessageTypeEnum::text, $admin->mobile_no, $admin->name, NULL, [], [
                        $admin->name
                    ], [], NULL, true, $admin->id, UserAdminModel::class);
                }
            }
        }
    }
}
