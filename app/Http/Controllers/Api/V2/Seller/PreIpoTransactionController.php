<?php

namespace App\Http\Controllers\Api\V2\Seller;

use App\Helpers\CommonHelper;
use App\Helpers\PreIpoTransactionHelper;
use App\Helpers\UtillsHelper;
use App\Http\Controllers\Controller;
use App\Models\PreIpoModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class PreIpoTransactionController extends Controller
{
    public function transaction(): JsonResponse
    {
        $request = request();
        $validation = Validator::make($request->all(), [
            'status' => 'nullable|in:pending,processing,completed',
            'company_id' => 'nullable',
            'company' => 'nullable|string',
            'skip' => 'nullable|integer|min:0',
            'take' => 'nullable|integer|min:1',
        ]);

        if ($validation->fails()) {
            return UtillsHelper::json(0, ['message' => $validation->errors()->first()]);
        }

        $skip = max(0, (int) $request->input('skip', 0));
        $take = (int) $request->input(
            'take',
            CommonHelper::appSettings('app_pagination_limit')
        );
        if ($take < 1) {
            $take = 15;
        }

        $status = $request->input('status');

        $transactions = PreIpoModel::where('seller_id', $request->user()->id)
            ->whereHas('investor', function ($q) {
                $q->where('is_deleted', 0);
            })
            ->when($status === 'pending', function ($q) {
                return $q->whereNull('created_by')->where('status', 0);
            })
            ->when($status === 'processing', function ($q) {
                return $q->where('status', '>', 1)->where('status', '!=', 5);
            })
            ->when($status === 'completed', function ($q) {
                return $q->where('status', 5);
            })
            ->when($request->filled('company_id'), function ($q) use ($request) {
                return $q->where('company_id', $request->company_id);
            })
            ->when($request->filled('company'), function ($q) use ($request) {
                return $q->whereHas('company', function ($c) use ($request) {
                    $c->where('brand_name', 'like', '%' . $request->company . '%');
                });
            })
            ->with(['company:id,uuid,brand_name,logo', 'investor:id,name'])
            ->orderByDesc('id')
            ->skip($skip)
            ->take($take)
            ->get()
            ->map(function ($transaction) {
                $transaction->company?->setAppends([]);
                $transaction->status_list = PreIpoTransactionHelper::getStatusListForApplicationV2($transaction);

                if (in_array($transaction->status, [1, 5])) {
                    $transaction->makeHidden('transaction_cancel_timer');
                }

                return $transaction;
            });

        return UtillsHelper::json(1, [
            'message' => 'Transaction List',
            'data' => $transactions,
        ], 200);
    }

    public function transactionDetail(): JsonResponse
    {
        $request = request();
        $validation = Validator::make($request->all(), [
            'transaction_id' => 'required',
        ]);

        if ($validation->fails()) {
            return UtillsHelper::json(0, ['message' => $validation->errors()->first()]);
        }

        $transaction = PreIpoModel::with('company')
            ->where('id', $request->transaction_id)
            ->where('seller_id', $request->user()->id)
            ->whereHas('investor', function ($q) {
                $q->where('is_deleted', 0);
            })
            ->first();

        if (!$transaction) {
            return UtillsHelper::json(0, [
                'message' => 'Transaction not found or does not belong to the user.',
            ]);
        }

        $transaction->company?->makeHidden(['transaction']);
        $transaction->status_list = PreIpoTransactionHelper::getStatusListForApplicationV2($transaction);

        if (in_array($transaction->status, [1, 5])) {
            $transaction->makeHidden('transaction_cancel_timer');
        }

        return UtillsHelper::json(1, [
            'message' => 'Transaction details fetched successfully',
            'data' => $transaction,
        ]);
    }
}
