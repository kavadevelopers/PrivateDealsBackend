<?php

namespace App\Http\Controllers\Api\V2\Investor;

use App\Helpers\TransactionCalculationHelper;
use App\Helpers\UtillsHelper;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class TransactionCalculationController extends Controller
{
    public function calculateTransaction(): JsonResponse
    {
        $request = request();

        $validation = Validator::make($request->all(), [
            'company_id' => 'required',
            'quantity' => 'required',
            'master_coupon_id' => 'nullable|integer|exists:master_coupon,id',
            'transaction_type' => 'nullable|in:primary,secondary,pre_ipo',
        ]);

        if ($validation->fails()) {
            return UtillsHelper::json(0, [
                'message' => 'Validation failed',
                'errors' => $validation->errors(),
            ]);
        }

        try {
            $companyId = $request->input('company_id');
            $quantity = $request->input('quantity');
            $masterCouponId = $request->input('master_coupon_id');
            $transactionType = $request->input('transaction_type', 'pre_ipo');


            $calculation = TransactionCalculationHelper::calculateTransactionAmount(
                $companyId,
                $quantity,
                $masterCouponId,
                $transactionType
            );

            return UtillsHelper::json(1, [
                'message' => 'Transaction calculation completed successfully',
                'data' => $calculation,
            ]);
        } catch (Exception $e) {
            return UtillsHelper::json(0, [
                'message' => 'Error calculating transaction: ' . $e->getMessage(),
            ]);
        }
    }
}
