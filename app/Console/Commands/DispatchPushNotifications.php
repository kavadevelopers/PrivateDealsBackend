<?php

namespace App\Console\Commands;

use App\Jobs\FirebasePushNotificationSendJob;
use App\Models\NotificationsModel;
use App\Traits\FirebaseTrait;
use Illuminate\Console\Command;

class DispatchPushNotifications extends Command
{
    use FirebaseTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:dispatch-push-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $unsentNotifications = NotificationsModel::where('is_sent', 0)
            ->orderBy('id', 'asc')
            ->limit(50)
            ->get();

        foreach ($unsentNotifications as $notification) {
            // FirebasePushNotificationSendJob::dispatch($notification->id);
            // $notification->update(['is_sent' => 1]);
            // $this->info("Dispatched Notification ID: {$notification->id}");
            $this->sendPushNow($notification);
            // $notification->update(['is_sent' => 1]);
        }

        // $this->info("Finished dispatching push notifications.");
    }
}
