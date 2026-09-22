<?php

namespace App\Helpers;

use App\Enums\DocumentTypeEnum;
use App\Enums\NotificationTypeEnum;
use App\Enums\WpMessageTypeEnum;
use App\Models\DocumentsModel;
use App\Models\DocumentsSignersModel;
use App\Models\InvestorAifKycModel;
use App\Models\InvestorModel;
use App\Models\PreIpoModel;
use App\Models\ReportErrorLogModel;
use App\Services\PreIpoTimerService;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\Log;
use Throwable;

class DocumentHelper
{

    use FileUploadTrait;
    static function aifPPMDocumentSend(InvestorAifKycModel $kyc)
    {

        $documentRow = DocumentsModel::where('type', DocumentTypeEnum::ppm->value)->whereJsonContains('meta->aif_kyc', $kyc->id)->first();
        if ($documentRow) {
            $signers = [
                [
                    'identifier' => $kyc->investor->mobile_number,
                    'name' => $kyc->investor->name,
                    'sign_type' => 'electronic',  // Type of signature (aadhaar/electronic)
                    'reason' => 'AIF Onboarding PPM',
                    'user_id' => $kyc->investor->id,
                    'user_type' => InvestorModel::class
                ]
            ];
            $payload = [
                'signers' => $signers,
                'expire_in_days' => 90,
                'display_on_page' => 'all',  // Custom display option
                'notify_signers' => false,  // Notify signers
                'include_authentication_url' => true,
                "file_name" => $kyc->investor->name . "_aifOnboardPPM.pdf",
                'file_data' => base64_encode(file_get_contents(self::fileUrl($documentRow->path))),
                'sign_coordinates' => [
                    $kyc->investor->mobile_number => [
                        1 => [
                            [
                                'llx' => 6.999985653901641,
                                'lly' => 6.00835439433494,
                                'urx' => 146.99546999816394,
                                'ury' => 45.99961941995365
                            ]
                        ]
                    ]
                ],
            ];
            $sanitizedSigners = array_map(function ($signer) {
                return [
                    'identifier' => $signer['identifier'],
                    'name' => $signer['name'],
                    'sign_type' => $signer['sign_type'],
                    'reason' => $signer['reason']
                ];
            }, $payload['signers']);
            $apiPayload = array_merge($payload, ['signers' => $sanitizedSigners]);
            $request = DigioHelper::generateCustomDocument($apiPayload);
            if ($request->getStatusCode() == "200") {
                $getDocResponse = json_decode($request->getBody()->getContents(), true);
                $documentRow->api_id = $getDocResponse['id'];
                $documentRow->save();
                foreach ($payload['signers'] as $key => $signer) {
                    $signers = new DocumentsSignersModel();
                    $signers->document_id = $documentRow->id;
                    $signers->user_id = $signer['user_id'];
                    $signers->user_type = $signer['user_type'];
                    $signers->identifier = 'mobile';
                    $signers->identifier_value = $signer['identifier'];
                    $signers->link = $getDocResponse['signing_parties'][$key]['authentication_url'] ?? null;
                    $signers->expire_on = $getDocResponse['signing_parties'][$key]['expire_on'] ?? null;
                    $signers->save();

                    WhatsAppMessagesHelper::aifOnboardPPMSent($kyc->investor ?? null, $signers->link ?? null);
                }
            } else {
                $getDocResponse = json_decode($request->getBody()->getContents(), true);
                ReportErrorLogModel::create([
                    'type' => 'Digio document create',
                    'subtype'   => 'Aif PPM Document',
                    'description' => $getDocResponse['message'] ?? 'Unknown error',
                    'notes'         => 'kyc = ' . $kyc->id
                ]);
            }
        } else {
            ReportErrorLogModel::create(attributes: [
                'type'      => 'Digio document create',
                'subtype'   => 'Aif PPM Document',
                'description'   => 'Cant find document',
                'notes'         => 'kyc = ' . $kyc->id
            ]);
        }
    }
    static function aifCADocumentSend(InvestorAifKycModel $kyc)
    {
        $documentRow = DocumentsModel::where('type', DocumentTypeEnum::ca->value)->whereJsonContains('meta->aif_kyc', $kyc->id)->first();
        if ($documentRow) {
            $signers = [
                [
                    'identifier' => $kyc->investor->mobile_number,
                    'name' => $kyc->investor->name,
                    'sign_type' => 'electronic',  // Type of signature (aadhaar/electronic)
                    'reason' => 'AIF Onboarding CA',
                    'user_id' => $kyc->investor->id,
                    'user_type' => InvestorModel::class
                ]
            ];
            $payload = [
                'signers' => $signers,
                'expire_in_days' => 90,
                'display_on_page' => 'all',  // Custom display option
                'notify_signers' => false,  // Notify signers
                'include_authentication_url' => true,
                "file_name" => $kyc->investor->name . "_aifOnboardCA.pdf",
                'file_data' => base64_encode(file_get_contents(self::fileUrl($documentRow->path))),
                'sign_coordinates' => [
                    $kyc->investor->mobile_number => [
                        1 => [
                            [
                                'llx' => 6.999985653901641,
                                'lly' => 6.00835439433494,
                                'urx' => 146.99546999816394,
                                'ury' => 45.99961941995365
                            ]
                        ]
                    ]
                ],
            ];
            $sanitizedSigners = array_map(function ($signer) {
                return [
                    'identifier' => $signer['identifier'],
                    'name' => $signer['name'],
                    'sign_type' => $signer['sign_type'],
                    'reason' => $signer['reason']
                ];
            }, $payload['signers']);
            $apiPayload = array_merge($payload, ['signers' => $sanitizedSigners]);
            $request = DigioHelper::generateCustomDocument($apiPayload);
            if ($request->getStatusCode() == "200") {
                $getDocResponse = json_decode($request->getBody()->getContents(), true);
                $documentRow->api_id = $getDocResponse['id'];
                $documentRow->save();
                foreach ($payload['signers'] as $key => $signer) {
                    $signers = new DocumentsSignersModel();
                    $signers->document_id = $documentRow->id;
                    $signers->user_id = $signer['user_id'];
                    $signers->user_type = $signer['user_type'];
                    $signers->identifier = 'mobile';
                    $signers->identifier_value = $signer['identifier'];
                    $signers->link = $getDocResponse['signing_parties'][$key]['authentication_url'] ?? null;
                    $signers->expire_on = $getDocResponse['signing_parties'][$key]['expire_on'] ?? null;
                    $signers->save();

                    WhatsAppMessagesHelper::aifOnboardCASent($kyc->investor ?? null, $signers->link ?? null);
                }
            } else {

                $getDocResponse = json_decode($request->getBody()->getContents(), true);
                ReportErrorLogModel::create([
                    'type' => 'Digio document create',
                    'subtype'   => 'Aif CA Document',
                    'description' => $getDocResponse['message'] ?? 'Unknown error',
                    'notes'         => 'kyc = ' . $kyc->id
                ]);
            }
        } else {
            ReportErrorLogModel::create(attributes: [
                'type'      => 'Digio document create',
                'subtype'   => 'Aif CA Document',
                'description'   => 'Cant find document',
                'notes'         => 'kyc = ' . $kyc->id
            ]);
        }
    }

    static function dealSlipDocumentSend(PreIpoModel $transaction, $ignoreKycCheck = false)
    {
        // Only send deal slip if KYC is done, unless ignoreKycCheck is true
        if (!$ignoreKycCheck && !($transaction->investor && $transaction->investor->preipo_kyc_status)) {
            Log::info('Deal slip not sent: Investor KYC not completed for transaction ID ' . $transaction->id);
            return;
        }
        if ($transaction->seller && $transaction->investor) {
            $investor = $transaction->investor;
            $investorMobile = $investor->mobile_number;
            $getPremium = 0;
            if ($transaction->company &&  $transaction->company->fundamentals && $transaction->company->fundamentals->face_value) {
                $getPremium = $transaction->share_price - $transaction->company->fundamentals->face_value;
            }
            $signers = [
                [
                    'identifier' => $investorMobile,
                    'name' => $investor->name,
                    'sign_type' => 'electronic',  // Type of signature (aadhaar/electronic)
                    'reason' => 'Deal Slip of ' . $transaction->company->brand_name,
                    'user_id' => $investor->id,
                    'user_type' => InvestorModel::class
                ]
            ];
            $payload = [
                'templates'                 => [
                    [
                        'template_key'          => 'TMP241114163701551BIP1FY2J6PL6I6',
                        'template_values'       => [
                            'date'               => DateTimeHelper::viewDate($transaction->created_at),
                            'company_cin'                       => $transaction->company->cin ?? 'NA',
                            'company_legal_name'                => $transaction->company->company_name ?? 'NA',
                            'face_value'                        => $transaction->company->fundamentals->face_value ?? 'NA',
                            'shares'                            => $transaction->shares ?? 'NA',
                            'price'                             => $transaction->share_price ?? 'NA',
                            'invested'                          => $transaction->investment_amount ?? 'NA',
                            'premium'                           => $getPremium,
                            'seller_cin'                        => $transaction->seller->cin ?? 'NA',
                            'seller_pan'                        => $transaction->seller->pan ?? 'NA',
                            'seller_name'                       => $transaction->seller->company_name ?? 'NA',
                            'seller_address'                    => $transaction->seller->address ?? 'NA',
                            'seller_dpid'                       => $transaction->seller->dp_id ?? 'NA',
                            'seller_clientid'                   => $transaction->seller->client_id ?? 'NA',
                            'seller_bank'                       => $transaction->seller->bank_name ?? 'NA',
                            'seller_ac_no'                      => $transaction->seller->account_number ?? 'NA',
                            'seller_ifsc'                       => $transaction->seller->ifsc ?? 'NA',
                            'seller_branch'                     => $transaction->seller->branch ?? 'NA',
                            'buyer_email'                       => $transaction->investor->email ?? 'NA',
                            'buyer_name'                        => $transaction->investor->name  ?? 'NA',
                            'buyer_cin'                         => 'NA',
                            'buyer_address'                     => $transaction->investor->address ?? 'NA',
                            'buyer_pan'                         => $transaction->investor->newPan->pan_no ?? 'NA',
                            'buyer_demat_account_no'            => $transaction->investor->dematAccount->demat_account ?? 'NA',
                        ]
                    ]
                ],
                'signers'                       => $signers,
                'expire_in_days'            => '10',
                'display_on_page'           => "custom",
                'send_sign_link'            => true,
                'notify_signers'            => true,
                'include_authentication_url' => true,
                'sign_coordinates'          => [
                    $investorMobile       =>  [
                        "2"                 =>  [
                            [
                                'llx'       => 78.00031132340936,
                                'lly'       => 103.00664573232837,
                                'urx'       => 217.99893927208885,
                                'ury'       => 143.0001145808905
                            ]
                        ]
                    ]
                ]
            ];
            $sanitizedSigners = array_map(function ($signer) {
                return [
                    'identifier' => $signer['identifier'],
                    'name' => $signer['name'],
                    'sign_type' => $signer['sign_type'],
                    'reason' => $signer['reason']
                ];
            }, $payload['signers']);
            $postJson = array_merge($payload, ['signers' => $sanitizedSigners]);

            $client = new \GuzzleHttp\Client(['verify' => false, 'http_errors' => false]);
            try {
                $sendOffer = $client->post(CommonHelper::appSettings('digio_url') . 'v2/client/template/multi_templates/create_sign_request', [
                    'headers' => [
                        'Content-Type'  => 'application/json',
                        'Accept'        => 'application/json',
                        'Authorization' => 'Basic ' . base64_encode(CommonHelper::appSettings('digio_client_id') . ':' . CommonHelper::appSettings('digio_client_secret')),
                    ],
                    'json' => $postJson
                ]);
            } catch (\Exception $e) {
                $sendOffer = $e->getMessage();
            }
            if ($sendOffer->getStatusCode() == "200") {

                $getDocResponse = json_decode($sendOffer->getBody()->getContents());
                $offerId = $getDocResponse->id;
                $document = new DocumentsModel();
                $document->api_id = $offerId;
                $document->type = DocumentTypeEnum::preipodealslip;
                $document->meta = [
                    'name' => 'Deal slip - ' . $transaction->company->brand_name,
                    'investor' => [
                        $transaction->investor->id
                    ],
                    'preipo_transactions' => [
                        $transaction->id
                    ]
                ];
                $document->save();

                foreach ($payload['signers'] as $key => $signer) {
                    $signers = new DocumentsSignersModel();
                    $signers->document_id = $document->id;
                    $signers->user_id = $signer['user_id'];
                    $signers->user_type = $signer['user_type'];
                    $signers->identifier = 'mobile';
                    $signers->identifier_value = $signer['identifier'];
                    $signers->link = $getDocResponse->signing_parties[$key]->authentication_url ?? null;
                    $signers->expire_on = $getDocResponse->signing_parties[$key]->expire_on ?? null;
                    $signers->save();
                    // Log::info('Response Digio: ' . var_dump($getDocResponse));

                    $params = [
                        $transaction->transaction_invoice_no,
                        $transaction->company->brand_name,
                        $transaction->shares,
                        UtillsHelper::moneyFormatIndia($transaction->investment_amount),
                    ];

                    UtillsHelper::sendWpMessage(
                        NotificationTypeEnum::event,
                        'preipo_on_dealslip_investor_sun_1',
                        WpMessageTypeEnum::text,
                        $transaction->investor->mobile_number,
                        $transaction->investor->name,
                        null,
                        [$signers->link],
                        $params
                    );

                    UtillsHelper::sendNotification(
                        $transaction->investor->id,
                        InvestorModel::class,
                        'preipo-transaction',
                        'Private Equity transaction',
                        UtillsHelper::paramsToTemplate(
                            $params,
                            'Your transaction #{{1}} has been approved and deal slip for the same has been generated. Kindly review and sign the deal slip via button, given below, at your earliest to continue with the process. Company: {{2}} Quantity: {{3}} Buying Price: {{4}} For any assistance related to this transaction, please contact our support team.'
                        )
                    );
                }

                $transaction->status = 2;
                $transaction->save();
            } else {
                $getDocResponse = json_decode($sendOffer->getBody()->getContents());
                ReportErrorLogModel::create([
                    'type' => 'Digio',
                    'subtype'   => 'Pre-IPO Send api error',
                    'description'   => $getDocResponse,
                    'notes'         => 'transaction = ' . $transaction->id
                ]);
            }
        }
    }
}
