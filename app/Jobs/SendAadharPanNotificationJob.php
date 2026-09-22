<?php

namespace App\Jobs;

use App\Enums\AdminTypeEnum;
use App\Enums\NotificationTypeEnum;
use App\Enums\WpMessageTypeEnum;
use App\Helpers\UtillsHelper;
use App\Models\UserAdminModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendAadharPanNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public string $investorName;
    public function __construct(string $investorName)
    {
        $this->investorName = $investorName;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $admins = UserAdminModel::where('is_deleted', '0')
            ->where('role', AdminTypeEnum::manager->value)
            ->get();

        foreach ($admins as $admin) {
            if ($admin->mobile_no) {
                UtillsHelper::sendWpMessage(
                    NotificationTypeEnum::regular,
                    'aadhar_pan_kyc_submission_verification',
                    WpMessageTypeEnum::text,
                    $admin->mobile_no,
                    $admin->name,
                    null,
                    [],
                    [$this->investorName]
                );
            }
        }
    }
}
