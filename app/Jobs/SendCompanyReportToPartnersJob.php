<?php

namespace App\Jobs;

use App\Enums\NotificationTypeEnum;
use App\Enums\WpMessageTypeEnum;
use App\Helpers\AdminHelper;
use App\Helpers\FileUpDownHelper;
use App\Helpers\UtillsHelper;
use App\Models\PartnerModel;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendCompanyReportToPartnersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $headerFile;
    protected $category;
    protected $partnerIds;
    protected $isDemo;

    /**
     * Create a new job instance.
     */
    public function __construct($headerFile, $category, $partnerIds, $isDemo = false)
    {
        $this->headerFile = $headerFile;
        $this->category = $category;
        $this->partnerIds = $partnerIds;
        $this->isDemo = $isDemo;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $partners = PartnerModel::whereIn('id', $this->partnerIds)
                ->where('is_deleted', 0)
                ->get();

            foreach ($partners as $partner) {
                $params = [
                    $partner->name,
                    now()->format('d M Y')
                ];

                UtillsHelper::sendWpMessage(
                    NotificationTypeEnum::regular,
                    'company_share_price_report_send_to_partners_and_demo',
                    WpMessageTypeEnum::media,
                    $partner->mobile_number,
                    $partner->name,
                    FileUpDownHelper::fileUrl($this->headerFile),
                    [],
                    $params,
                    [],
                    null,
                    false,
                    $partner->id,
                    PartnerModel::class
                );

                AdminHelper::logPut('Company PDF report sent to partner: ' . $partner->name, PartnerModel::class, $partner->id);
            }
        } catch (Exception $e) {
            Log::error('Failed to send PDF via WhatsApp Job: ' . $e->getMessage());
            throw $e; // Re-throw to mark job as failed
        }
    }
}
