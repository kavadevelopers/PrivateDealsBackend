<?php

namespace App\Jobs\broadcast;

use App\Enums\MessagesStatusEnum;
use App\Enums\NotificationTypeEnum;
use App\Enums\WpMessageTypeEnum;
use App\Helpers\FileUpDownHelper;
use App\Helpers\UtillsHelper;
use App\Models\InvestorModel;
use App\Models\PartnerModel;
use App\Models\ReportMessagesWhatsappModel;
use App\Models\WhatsappBroadcastModel;
use App\Traits\WhatsAppSendTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Whatsapp implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, WhatsAppSendTrait;

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
        $broadcast = WhatsappBroadcastModel::where('id', $this->item_id)->first();
        if ($broadcast) {
            $WpMessageTypeEnum = $broadcast->header_file ? WpMessageTypeEnum::media : WpMessageTypeEnum::text;
            $investors_ids =  json_decode($broadcast->investors_ids);
            $partners_ids =  json_decode($broadcast->partners_ids);
            $guest_data = json_decode($broadcast->guest_data);
            if (count($investors_ids) > 0) {
                foreach ($investors_ids as $key => $investor_id) {
                    $investor =  InvestorModel::where('id', $investor_id)->first();
                    if ($investor) {
                        // $old = ReportMessagesWhatsappModel::where('broadcast_id',$broadcast->id)->where('destination_mobile_no',$investor->mobile_number)->first();
                        // if(!$old){
                        $params = [];
                        if ($broadcast->variables != NULL) {
                            $tmpParams = json_decode($broadcast->variables);
                            foreach ($tmpParams as $tmpPkey => $tmpPvalue) {
                                if ($tmpPvalue->value != NULL) {
                                    array_push($params, $tmpPvalue->value);
                                } else {
                                    $column = $tmpPvalue->type;
                                    array_push($params, $investor->$column);
                                }
                            }
                        }

                        UtillsHelper::sendWpMessage(
                            NotificationTypeEnum::regular,
                            $broadcast->template_name,
                            $WpMessageTypeEnum,
                            $investor->mobile_number,
                            $investor->name,
                            $broadcast->header_file ? FileUpDownHelper::fileUrl($broadcast->header_file) : NULL,
                            json_decode($broadcast->dynamic_urls) ?? [],
                            $params,
                            [$broadcast->id],
                            $broadcast->id,
                            false,
                            $investor->id,
                            InvestorModel::class
                        );
                        // }else{
                        //     if($old->status == MessagesStatusEnum::pending->value){
                        //         $this->sendNowWhatsApp($old);
                        //     }
                        // }
                    }
                }
            }
            if (count($partners_ids) > 0) {
                foreach ($partners_ids as $key => $partners_id) {
                    $partner =  PartnerModel::where('id', $partners_id)->first();
                    if ($partner) {
                        // $old = ReportMessagesWhatsappModel::where('broadcast_id',$broadcast->id)->where('destination_mobile_no',$investor->mobile_number)->first();
                        // if(!$old){
                        $params = [];
                        if ($broadcast->variables != NULL) {
                            $tmpParams = json_decode($broadcast->variables);
                            foreach ($tmpParams as $tmpPkey => $tmpPvalue) {
                                if ($tmpPvalue->value != NULL) {
                                    array_push($params, $tmpPvalue->value);
                                } else {
                                    $column = $tmpPvalue->type;
                                    array_push($params, $partner->$column);
                                }
                            }
                        }

                        UtillsHelper::sendWpMessage(
                            NotificationTypeEnum::regular,
                            $broadcast->template_name,
                            $WpMessageTypeEnum,
                            $partner->mobile_number,
                            $partner->name,
                            $broadcast->header_file ? FileUpDownHelper::fileUrl($broadcast->header_file) : NULL,
                            json_decode($broadcast->dynamic_urls) ?? [],
                            $params,
                            [$broadcast->id],
                            $broadcast->id,
                            false,
                            $partner->id,
                            PartnerModel::class
                        );
                        // }else{
                        //     if($old->status == MessagesStatusEnum::pending->value){
                        //         $this->sendNowWhatsApp($old);
                        //     }
                        // }
                    }
                }
            }
            if (is_array($guest_data) && count($guest_data) > 0) {
                foreach ($guest_data as $guest) {
                    if (isset($guest[0]) && isset($guest[1])) {
                        $guest_name = $guest[0];
                        $guest_mobile = $guest[1];

                        $params = [];
                        if ($broadcast->variables != NULL) {
                            $tmpParams = json_decode($broadcast->variables);
                            foreach ($tmpParams as $tmpPkey => $tmpPvalue) {
                                if ($tmpPvalue->value != NULL) {
                                    array_push($params, $tmpPvalue->value);
                                } else {
                                    // For guest data, we can only use the name since we don't have other fields
                                    $column = $tmpPvalue->type;
                                    if ($column === 'name') {
                                        array_push($params, $guest_name);
                                    } else {
                                        array_push($params, ''); // Empty for other fields
                                    }
                                }
                            }
                        }

                        UtillsHelper::sendWpMessage(
                            NotificationTypeEnum::regular,
                            $broadcast->template_name,
                            $WpMessageTypeEnum,
                            $guest_mobile,
                            $guest_name,
                            $broadcast->header_file ? FileUpDownHelper::fileUrl($broadcast->header_file) : NULL,
                            json_decode($broadcast->dynamic_urls) ?? [],
                            $params,
                            [$broadcast->id],
                            $broadcast->id,
                            false,
                            null,
                            null
                        );
                    }
                }
            }
        }
    }
}
