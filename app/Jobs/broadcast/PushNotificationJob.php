<?php

namespace App\Jobs\broadcast;

use App\Models\BroadcastNotificationModel;
use App\Models\InvestorModel;
use App\Models\NotificationsModel;
use App\Models\PartnerModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PushNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $broadcastId;
    public function __construct($broadcastId)
    {
        $this->broadcastId = $broadcastId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $broadcast = BroadcastNotificationModel::find($this->broadcastId);
        if ($broadcast) {
            $investorIds = json_decode($broadcast->investors_ids, true) ?? [];
            $partnerIds = json_decode($broadcast->partners_ids, true) ?? [];

            // $payload = $this->getFormattedPayload();
            $payload = [];

            if (!empty($broadcast->data)) {
                if (is_string($broadcast->data)) {
                    $payload = json_decode($broadcast->data, true);
                } elseif (is_array($broadcast->data)) {
                    $payload = $broadcast->data;
                }
            }

            foreach ($investorIds as $id) {
                NotificationsModel::create([
                    'user_id'    => $id,
                    'user_type'  => InvestorModel::class,
                    'url'        => 'home',
                    'title'      => $broadcast->title,
                    'body'       => $broadcast->body,
                    'image'      => $broadcast->image,
                    'broadcast_id' => $broadcast->id,
                    'payload'    => $payload,
                    'is_readed'  => '0'
                ]);
            }

            foreach ($partnerIds as $id) {
                NotificationsModel::create([
                    'user_id'    => $id,
                    'user_type'  => PartnerModel::class,
                    'url'        => 'home',
                    'title'      => $broadcast->title,
                    'body'       => $broadcast->body,
                    'image'      => $broadcast->image,
                    'broadcast_id' => $broadcast->id,
                    'payload'    => $payload,
                    'is_readed'  => '0'
                ]);
            }
        }
    }

    // protected function getFormattedPayload(): array
    // {
    //     $data = $broadcast->data ?? [];

    //     if (!empty($data['reference_id']) && !empty($data['reference_type'])) {
    //         if ($data['reference_type'] === 'company') {
    //             $data['redirect_to'] = 'home/pre-ipo/news?id=' . $data['reference_id'];
    //         } elseif ($data['reference_type'] === 'startup') {
    //             $data['redirect_to'] = 'home/primary/news?id=' . $data['reference_id'];
    //         }
    //     }

    //     return $data;
    // }
}
