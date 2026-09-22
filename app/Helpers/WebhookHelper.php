<?php

namespace App\Helpers;

use App\Enums\DocumentTypeEnum;
use App\Models\InvestorAifKycModel;
use App\Models\InvestorModel;
use Illuminate\Support\Facades\Storage;

class WebhookHelper
{

    static function aifOnboard($document, $file): void
    {
        $name = CommonHelper::generateFileName() . '.pdf';
        $path = 'kyc/signed/aif/' . $name;
        if (Storage::disk('s3')->put($path, $file, 'public')) {
            $document->signed_path = $path;
            $document->status = 1;
            $document->save();
            if (count($document->meta->aif_kyc) > 0) {
                foreach ($document->meta->aif_kyc as $key => $value) {
                    $kyc = InvestorAifKycModel::find($value);
                    if ($kyc) {
                        if ($document->type == DocumentTypeEnum::ca->value) {
                            $kyc->ca_signed = 1;
                        }
                        if ($document->type == DocumentTypeEnum::ppm->value) {
                            $kyc->ppm_signed = 1;
                        }
                        if ($kyc->ppm_signed == '1' && $kyc->ca_signed == '1') {
                            $kyc->status = 3;
                        }
                        $kyc->save();
                        if ($kyc && $kyc->status == '3') {

                            // InvestorModel::where('id', $kyc->investor_id)->update(['aif_status' => 1]);
                            $kyc->investor->update(['aif_status' => 1]);
                            WhatsAppMessagesHelper::aifOnboardSigned($kyc->investor ?? null);
                        }
                    }
                }
            }
        }
    }

    static function dealslipWebhook($document, $file): void
    {
        $name = CommonHelper::generateFileName() . '.pdf';
        $path = 'preipo/' . $name;
        if (Storage::disk('s3')->put($path, $file, 'public')) {
            $document->path = $path;
            $document->signed_path = $path;
            $document->status = 1;
            $document->save();
            PreIpoTransactionHelper::changeTransactionStatus($document);
        }
    }
}
