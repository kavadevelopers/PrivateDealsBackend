<?php

namespace App\Helpers;

use App\Enums\DocumentTypeEnum;
use App\Enums\PrimaryTransactionTypeEnum;
use App\Models\DocumentsModel;
use App\Models\PrimaryTransactionModel;
use App\Models\ReportErrorLogModel;

class PrimaryTransactionHelper
{
    static function getStatusListForApplication(PrimaryTransactionModel $transaction): array
    {
        $list = [];
        if ($transaction->type == PrimaryTransactionTypeEnum::captable->value) {


            $list[] = [
                'title'         => 'Committed',
                'description'   => 'Investment Committed',
                'date'          => $transaction->created_at,
                'document'      => null,
                'action'        => null,
                'is_active'     => $transaction->status == 2 ? true : false,
            ];

            $list[] = [
                'title'         => 'SSA Signed',
                'description'   => 'Share Subscription Agreement Signed',
                'date'          => $transaction->ssa_document->created_at ?? null,
                'document'      => $transaction->ssa_document,
                'action'        => null,
                'is_active'     => $transaction->status == 3 ? true : false,
            ];

            $list[] = [
                'title'         => 'MGT-14 Filed',
                'description'   => 'MGT-14 form successfully filed',
                'date'          => $transaction->mgt_zip_document->created_at ?? null,
                'document'      => $transaction->mgt_zip_document,
                'action'        => null,
                'is_active'     => in_array($transaction->status, [4, 5]) ? true : false,
            ];

            $list[] = [
                'title'         => 'Offer Signed',
                'description'   => 'Offer Letter signed by investor',
                'date'          => $transaction->offer_document->created_at ?? null,
                'document'      => $transaction->offer_document,
                'action'        => null,
                'is_active'     => $transaction->status == 6 ? true : false,
            ];

            $paymentDocument = $transaction->rtgs_receipt ?? $transaction->counter_slip;
            $list[] = [
                'title'         => 'Payment Transferred',
                'description'   => 'Investment amount transferred',
                'date'          => $paymentDocument->created_at ?? null,
                'document'      => $paymentDocument,
                'action'        => null,
                'is_active'     => $transaction->status == 7 ? true : false,
            ];

            $list[] = [
                'title'         => 'PAS-3 Filed',
                'description'   => 'PAS-3 form successfully filed',
                'date'          => $transaction->pas_zip_document->created_at ?? null,
                'document'      => $transaction->pas_zip_document,
                'action'        => null,
                'is_active'     => $transaction->status == 8 ? true : false,
            ];

            $list[] = [
                'title'         => 'SHA Signed',
                'description'   => 'Shareholder Agreement signed',
                'date'          => $transaction->sha_document->created_at ?? null,
                'document'      => $transaction->sha_document,
                'action'        => null,
                'is_active'     => false,
            ];

            $list[] = [
                'title'         => 'Completed',
                'description'   => 'Transaction successfully completed',
                'date'          => $transaction->updated_at,
                'document'      => null,
                'action'        => null,
                'is_active'     => $transaction->status == 10 ? true : false
            ];
        } else {
            $list[] = [
                'title'         => 'Committed',
                'description'   => 'Investment Committed',
                'date'          => $transaction->created_at,
                'document'      => null,
                'action'        => null,
                'is_active'     => $transaction->status == 2 ? true : false,
            ];

            $list[] = [
                'title'         => 'LOI Signed',
                'description'   => 'LOI signing completed',
                'date'          => $transaction->loi_document->created_at ?? null,
                'document'      => $transaction->loi_document,
                'action'        => null,
                'is_active'     => $transaction->status == 3 ? true : false,
            ];

            $list[] = [
                'title'         => 'Completed',
                'description'   => 'Transaction successfully completed',
                'date'          => $transaction->updated_at,
                'document'      => null,
                'action'        => null,
                'is_active'     => $transaction->status == 4 ? true : false
            ];
        }
        return $list;
    }

    static function sendLOI($transaction): void
    {
        if ($transaction->startup && $transaction->investor) {
            if ($transaction->investor->mobile_number) {
                $sendSSA = DigioHelper::sendLOINow($transaction);
                if ($sendSSA->getStatusCode() == "200") {
                    $getDocResponse = json_decode($sendSSA->getBody()->getContents());
                    $ssaId = $getDocResponse->id;
                    $document = new DocumentsModel();
                    $document->api_id = $ssaId;
                    $document->type = DocumentTypeEnum::loi;
                    $document->meta = [
                        'name' => 'LOI - ' . $transaction->startup->brand_name,
                        'sname' => 'LOI - ' . $transaction->investor->name,
                        'investor' => [
                            $transaction->investor->id
                        ],
                        'startup' => [
                            $transaction->startup->id
                        ],
                        'primary_transactions' => [
                            $transaction->id
                        ]
                    ];
                    $document->save();

                    $transaction->status = 2;
                    $transaction->save();
                } else {
                    $getDocResponse = json_decode($sendSSA->getBody()->getContents());
                    ReportErrorLogModel::create([
                        'type' => 'Digio',
                        'subtype'   => 'LOI Send api error',
                        'description'   => $getDocResponse,
                        'notes'         => 'transaction = ' . $transaction->id
                    ]);
                }
            } else {
                ReportErrorLogModel::create([
                    'type' => 'Digio',
                    'subtype'   => 'LOI Send identifier problem',
                    'description'   => 'Check startup and investor mobile number',
                    'notes'         => 'transaction = ' . $transaction->id
                ]);
            }
        } else {
            ReportErrorLogModel::create([
                'type' => 'Digio',
                'subtype'   => 'LOI Send data error',
                'description'   =>
                'Data proble check the data here = $transaction->startup && $transaction->investor && $transaction->investor->kyc && $transaction->startup->StartupOtherOne',
                'notes'         => 'transaction = ' . $transaction->id
            ]);
        }
    }

    static function sendSSA($transaction): void
    {
        if ($transaction->startup && $transaction->investor && $transaction->investor->kyc && $transaction->startup->StartupOtherOne && $transaction->startup->StartupOtherOne->ssa_sign_coordinates) {
            if ($transaction->startup->mobile_number !=  $transaction->investor->mobile_number) {
                $sendSSA = DigioHelper::sendSSANow($transaction);
                if ($sendSSA->getStatusCode() == "200") {
                    $getDocResponse = json_decode($sendSSA->getBody()->getContents());
                    $ssaId = $getDocResponse->id;
                    $document = new DocumentsModel();
                    $document->api_id = $ssaId;
                    $document->type = DocumentTypeEnum::ssa;
                    $document->meta = [
                        'name' => 'SSA - ' . $transaction->startup->brand_name,
                        'sname' => 'SSA - ' . $transaction->investor->name,
                        'investor' => [
                            $transaction->investor->id
                        ],
                        'startup' => [
                            $transaction->startup->id
                        ],
                        'primary_transactions' => [
                            $transaction->id
                        ]
                    ];
                    $document->save();

                    $transaction->status = 2;
                    $transaction->save();
                } else {
                    $getDocResponse = json_decode($sendSSA->getBody()->getContents());
                    ReportErrorLogModel::create([
                        'type' => 'Digio',
                        'subtype'   => 'SSA Send api error',
                        'description'   => $getDocResponse,
                        'notes'         => 'transaction = ' . $transaction->id
                    ]);
                }
            } else {
                ReportErrorLogModel::create([
                    'type' => 'Digio',
                    'subtype'   => 'SSA Send identifier problem',
                    'description'   => 'Check startup and investor mobile number',
                    'notes'         => 'transaction = ' . $transaction->id
                ]);
            }
        } else {
            ReportErrorLogModel::create([
                'type' => 'Digio',
                'subtype'   => 'SSA Send data error',
                'description'   =>
                'Data proble check the data here = $transaction->startup && $transaction->investor && $transaction->investor->kyc && $transaction->startup->StartupOtherOne',
                'notes'         => 'transaction = ' . $transaction->id
            ]);
        }
    }

    static function sendOffer($transaction): void
    {
        if ($transaction->startup && $transaction->investor && $transaction->investor->kyc && $transaction->startup->StartupOtherOne) {
            if ($transaction->startup->mobile_number !=  $transaction->investor->mobile_number) {
                $sendOffer = DigioHelper::sendOfferNow($transaction);
                if ($sendOffer->getStatusCode() == "200") {
                    $getDocResponse = json_decode($sendOffer->getBody()->getContents());
                    $offerId = $getDocResponse->id;
                    $document = new DocumentsModel();
                    $document->api_id = $offerId;
                    $document->type = DocumentTypeEnum::offer;
                    $document->meta = [
                        'name' => 'Offerletter - ' . $transaction->startup->brand_name,
                        'sname' => 'Offerletter - ' . $transaction->investor->name,
                        'investor' => [
                            $transaction->investor->id
                        ],
                        'startup' => [
                            $transaction->startup->id
                        ],
                        'primary_transactions' => [
                            $transaction->id
                        ]
                    ];
                    $document->save();

                    $transaction->status = 5;
                    $transaction->save();
                } else {
                    $getDocResponse = json_decode($sendOffer->getBody()->getContents());
                    ReportErrorLogModel::create([
                        'type' => 'Digio',
                        'subtype'   => 'Offer Send api error',
                        'description'   => $getDocResponse,
                        'notes'         => 'transaction = ' . $transaction->id
                    ]);
                }
            } else {
                ReportErrorLogModel::create([
                    'type' => 'Digio',
                    'subtype'   => 'Offer Send identifier problem',
                    'description'   => 'Check startup and investor mobile number',
                    'notes'         => 'transaction = ' . $transaction->id
                ]);
            }
        } else {
            ReportErrorLogModel::create([
                'type' => 'Digio',
                'subtype'   => 'Offer Send data error',
                'description'   =>
                'Data proble check the data here = $transaction->startup && $transaction->investor && $transaction->investor->kyc && $transaction->startup->StartupOtherOne',
                'notes'         => 'transaction = ' . $transaction->id
            ]);
        }
    }

    static function changeTransactionStatus($document): void
    {
        if ($document) {
            foreach ($document->meta->primary_transactions as $key => $value) {
                $transaction = PrimaryTransactionModel::find($value);
                if ($transaction) {
                    if ($document->type == DocumentTypeEnum::loi->value) {
                        if ($transaction->status == 2) {
                            $transaction->status = 3;
                            $transaction->save();
                        }
                    }
                    if ($document->type == DocumentTypeEnum::ssa->value) {
                        if ($transaction->status == 2) {
                            $transaction->status = 3;
                            $transaction->save();
                        }
                    }
                    if ($document->type == DocumentTypeEnum::offer->value) {
                        if ($transaction->status == 5) {
                            $transaction->status = 6;
                            $transaction->save();
                        }
                    }
                    if ($document->type == DocumentTypeEnum::sha->value) {
                        if ($transaction->status == 9) {
                            $transaction->status = 10;
                            $transaction->save();
                        }
                    }
                }
            }
        }
    }
}
