<?php

namespace App\Http\Controllers\Api\V1\Investor;

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
            'company_id' => 'required|integer|exists:company,id',
            'quantity' => 'required|integer|min:1',
            'investor_coupon_id' => 'nullable|integer|exists:investor_coupon,id',
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
            $investorCouponId = $request->input('investor_coupon_id');

            $calculation = TransactionCalculationHelper::calculateTransactionAmount(
                $companyId,
                $quantity,
                $investorCouponId
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
