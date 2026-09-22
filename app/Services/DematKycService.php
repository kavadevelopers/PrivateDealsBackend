<?php

namespace App\Services;


use Exception;
use App\Models\DocumentsModel;
use App\Models\InvestorModel;
use App\Models\UserBankAccountModel;
use App\Models\InvestorKycPanModel;
use App\Models\InvestorDematAccountModel;
use App\Enums\DocumentTypeEnum;
use App\Enums\InvestorCouponStatusEnum;
use App\Helpers\FileUpDownHelper;
use App\Helpers\DateTimeHelper;
use App\Jobs\notifications\kyc\KycCompletedBroadcastJob;
use App\Jobs\SendDealSlipJob;
use App\Models\AppSettingsModel;
use App\Models\InvestorCouponModel;
use App\Models\MasterCouponModel;
use App\Models\PreIpoModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DematKycService
{
    public function saveDematKyc($investorId, $data, $cmlFile = null)
    {
        DB::beginTransaction();

        try {
            $document = null;

            if ($cmlFile) {
                $filePath = FileUpDownHelper::uploadInvestorDoc($cmlFile);

                if (!$filePath) {
                    throw new Exception('File upload failed.');
                }

                $docType = DocumentTypeEnum::clientmaster->value;

                $document = DocumentsModel::create([
                    'api_id' => null,
                    'path' => $filePath,
                    'signed_path' => $filePath,
                    'status' => 1,
                    'type' => $docType,
                    'meta' => [
                        'name' => 'KYC-' . $docType,
                        'investor' => [$investorId],
                    ],
                ]);
            }

            $demat = InvestorDematAccountModel::updateOrCreate(
                ['investor_id' => $investorId],
                [
                    'document_id' => $document?->id,
                    'dp_id' => $data['dp_id'],
                    'client_id' => $data['client_id'],
                    'demat_account' => $data['dp_id'] . $data['client_id'],
                ]
            );

            if (isset($data['account_number']) && $data['account_number']) {
                UserBankAccountModel::updateOrCreate(
                    ['user_id' => $investorId, 'user_type' => InvestorModel::class],
                    [
                        'account_number' => $data['account_number'],
                        'account_holder_name' => $data['name'],
                        'ifsc_code' => $data['ifsc_code'],
                        'bank_name' => $data['bank_name'] ?? null,
                    ]
                );
            }
            $dobFormatted = null;
            if (isset($data['dob']) && $data['dob']) {
                if (strpos($data['dob'], '-') !== false && strlen($data['dob']) === 10) {
                    if (substr($data['dob'], 4, 1) === '-') {
                        $dobFormatted = $data['dob'];
                    } else {
                        $dobFormatted = DateTimeHelper::formatDateTime($data['dob'], 'Y-m-d');
                    }
                } else {
                    $dobFormatted = $data['dob'];
                }
            }

            InvestorKycPanModel::updateOrCreate(
                ['investor_id' => $investorId],
                [
                    'pan_no' => $data['pan_no'],
                    'pan_name' => $data['name'],
                    'dob' => $dobFormatted,
                ]
            );

            $investor = InvestorModel::where('id', $investorId)->first();
            if ($investor) {
                $investor->name = $data['name'];
                $investor->preipo_kyc_status = 1;
                $investor->save();

                $fixedDateTime = Carbon::parse('2026-02-25 15:23:00');
                // Queue deal slip send for all pending Pre-IPO transactions
                $pendingTransactions = PreIpoModel::where('investor_id', $investor->id)
                    ->where('status', 2) // status 2 = deal slip send pending
                    ->where('created_at', '>', $fixedDateTime)
                    ->get();
                foreach ($pendingTransactions as $transaction) {
                    SendDealSlipJob::dispatch($transaction->id);
                }
            }

            DB::commit();

            DB::afterCommit(function () use ($investor) {
                KycCompletedBroadcastJob::dispatch($investor->id);
                $this->assignKycCouponIfEligible($investor);
            });

            return [
                'success' => true,
                'message' => 'KYC details saved successfully.',
                'data' => [
                    'demat' => $demat,
                    'investor' => $investor
                ]
            ];
        } catch (Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => 'Failed to save KYC details.',
                'error' => $e->getMessage()
            ];
        }
    }

    private function assignKycCouponIfEligible(InvestorModel $investor): void
    {
        $kycCouponId = AppSettingsModel::where('key', 'coupon_kyc_coupon_id')->value('value');
        if (!$kycCouponId) return;

        if ($investor->created_at->diffInHours(now()) > 48) return;

        $coupon = MasterCouponModel::where('id', $kycCouponId)
            ->where('is_active', 1)
            ->where('is_deleted', 0)
            ->first();

        if (!$coupon) return;

        $alreadyExists = InvestorCouponModel::where('investor_id', $investor->id)
            ->where('coupon_id', $kycCouponId)
            ->exists();

        if ($alreadyExists) return;

        InvestorCouponModel::create([
            'investor_id'  => $investor->id,
            'coupon_id'    => $kycCouponId,
            'referral_id'  => null,
            'display_code' => null,
            'reward_value' => null,
            'status'       => InvestorCouponStatusEnum::active->value,
            'assigned_at'  => now(),
        ]);
    }
}
