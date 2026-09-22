<?php

namespace App\Jobs;

use App\Models\CoreFirebaseDeviceTokenModel;
use App\Models\NotificationsModel;
use App\Models\ReportErrorLogModel;
use App\Services\FCMService;
use App\Traits\FirebaseTrait;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FirebasePushNotificationSendJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use FirebaseTrait;
    /**
     * Create a new job instance.
     */

    protected $notification_id;
    public function __construct(string $notification_id)
    {
        $this->notification_id = $notification_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $notification = NotificationsModel::find($this->notification_id);
        if ($notification) {
            $this->sendPushNow($notification);
        }
    }
}
