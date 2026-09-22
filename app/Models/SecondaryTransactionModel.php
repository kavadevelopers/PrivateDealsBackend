<?php

namespace App\Models;

use App\Enums\DocumentTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SecondaryTransactionModel extends Model
{
    use HasFactory;

    protected $table = 'secondary_transaction';

    protected $fillable = [
        'status',
        'startup_id',
        'portfolio_id',
        'c_portfolio_id',
        'buyer_id',
        'seller_id',
        'sell_request_id',
        'instrument',
        'shares',
        'share_price',
        'investment_amount',
        'is_promoter',
        'expired_at'
    ];

    protected $appends = ['current_status', 'next_step', 'percentage', 'sh4_document', 'share_transfer_receipt', 'payment_receipt'];
    public function getSh4DocumentAttribute(): ?DocumentsModel
    {
        return DocumentsModel::where('type', DocumentTypeEnum::secondarysh->value)->where('status', '1')->whereJsonContains('meta->secondary_transaction', $this->id)->first();
    }
    public function getShareTransferReceiptAttribute(): ?DocumentsModel
    {
        return DocumentsModel::where('type', DocumentTypeEnum::sharereceipt->value)->where('status', '1')->whereJsonContains('meta->secondary_transaction', $this->id)->first();
    }
    public function getPaymentReceiptAttribute(): ?DocumentsModel
    {
        return DocumentsModel::where('type', DocumentTypeEnum::paymentreceipt->value)->where('status', '1')->whereJsonContains('meta->secondary_transaction', $this->id)->first();
    }
    public function getPercentageAttribute()
    {
        return $this->status * 12.50;
    }

    public function getCurrentStatusAttribute(): string
    {
        $request = request();
        switch ($this->status) {
            case 0:
                return 'Rofr Sent';
            case 1:
                return 'ROFR Approved';
            case 2:
                return 'ROFR Rejected';
            case 3:
                return 'ROFR Expired';
            case 4:
                return 'SH4 Sent';
            case 5:
                return 'SH4 Signed';
            case 6:
                return 'Payment received';
            case 7:
                return 'Share transfered';
            case 8:
                return 'Completed';
            default:
                return 'Unknown';
        }
    }

    public function getNextStepAttribute(): string
    {
        $request = request();
        switch ($this->status) {
            case 0:
                return 'Approve or Reject transactions';
            case 1:
                return 'Waiting For SH4';
            case 2:
                return 'N/A';
            case 3:
                return 'N/A';
            case 4:
                return 'Sign SS4 Check your sms for the link from Digiotech Solutions';
            case 5:
                if ($request->is('api/*')) {
                    if ($request->user()->id == $this->buyer_id) {
                        return 'Pay Amount to escrow bank account.';
                    } else {
                        return 'NA';
                    }
                } else {
                    return 'NA';
                }
            case 6:
                if ($request->is('api/*')) {
                    if ($request->user()->id == $this->buyer_id) {
                        return 'Waiting for share transfer confirmation';
                    } else {
                        return 'Upload share transfer receipt';
                    }
                } else {
                    return 'Waiting for share transfer confirmation';
                }
            case 7:
                if ($request->is('api/*')) {
                    if ($request->user()->id == $this->buyer_id) {
                        return 'Confirm Share transfer';
                    } else {
                        return 'Waiting for share transfer confirmation';
                    }
                } else {
                    return 'Waiting for share transfer confirmation from seller';
                }
            case 8:
                return 'N/A';
            default:
                return 'Unknown';
        }
    }

    public function escrow(): HasOne
    {
        return $this->hasOne(SecondaryEscrowAccountModel::class, 'transaction_id');
    }

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(InvestorModel::class, 'buyer_id');
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(InvestorModel::class, 'seller_id');
    }

    public function portfolio(): BelongsTo
    {
        return $this->belongsTo(PortfolioModel::class, 'portfolio_id');
    }

    public function cportfolio(): HasMany
    {
        return $this->hasMany(PortfolioModel::class, 'c_portfolio_id');
    }

    public function sellRequest(): BelongsTo
    {
        return $this->belongsTo(SecondarySellRequestModel::class, 'sell_request_id');
    }

    public function startup(): BelongsTo
    {
        return $this->belongsTo(StartupModel::class, 'startup_id');
    }



    public function investor(): BelongsTo
    {
        return $this->belongsTo(InvestorModel::class, 'buyer_id');
    }

    public function investorCoupon(): BelongsTo
    {
        return $this->belongsTo(InvestorCouponModel::class, 'investor_coupon_id');
    }
}
