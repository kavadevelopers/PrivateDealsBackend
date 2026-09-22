<?php

namespace App\Models;

use App\Enums\DocumentTypeEnum;
use App\Enums\PaymentStatusEnum;
use App\Enums\PrimaryTransactionPaymentMode;
use App\Enums\PrimaryTransactionTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

class PrimaryTransactionModel extends Model
{
    use HasFactory;

    protected $table = 'primary_transaction';

    protected $fillable = [
        'type',
        'investor_id',
        'startup_id',
        'round_id',
        'mgt14_id',
        'pas3_id',
        'portfolio_id',
        'instrument',
        'offerletterno',
        'shares',
        'share_price',
        'investment_amount',
        'fees',
        'gst',
        'amount_payable',
        'payment_status',
        'payment_mode',
        'is_share_transfered',
        'status',
        'is_valid'
    ];
    public function investor(): BelongsTo
    {
        return $this->belongsTo(InvestorModel::class, 'investor_id');
    }

    public function portfolio(): hasMany
    {
        return $this->hasMany(PortfolioModel::class, 'portfolio_id');
    }

    public function startup(): BelongsTo
    {
        return $this->belongsTo(StartupModel::class, 'startup_id');
    }
    public function round(): BelongsTo
    {
        return $this->belongsTo(StartupRoundModel::class, 'round_id');
    }
    public function mgt14(): BelongsTo
    {
        return $this->belongsTo(PrimaryTransactionMgt14Model::class, 'mgt14_id');
    }

    public function lastPayment(): HasOne
    {
        return $this->hasOne(PrimaryTransactionPaymentModel::class, 'transaction_id')->orderby('id', 'desc');
    }

    protected $appends = ['current_status', 'next_step', 'percentage', 'ssa_document', 'mgt_challan_document', 'pas_zip_document', 'mgt_zip_document', 'offer_document', 'counter_slip', 'rtgs_receipt', 'sha_document', 'loi_document'];

    public function getLoiDocumentAttribute(): ?DocumentsModel
    {
        return DocumentsModel::where('type', DocumentTypeEnum::loi->value)->where('status', '1')->whereJsonContains('meta->primary_transactions', $this->id)->latest()->first();
    }

    public function getCounterSlipAttribute(): ?DocumentsModel
    {
        return DocumentsModel::where('type', DocumentTypeEnum::chequecounterslip->value)->where('status', '1')->whereJsonContains('meta->primary_transactions', $this->id)->latest()->first();
    }

    public function getRtgsReceiptAttribute(): ?DocumentsModel
    {
        return DocumentsModel::where('type', DocumentTypeEnum::rtgsreceipt->value)->where('status', '1')->whereJsonContains('meta->primary_transactions', $this->id)->latest()->first();
    }

    public function getShaDocumentAttribute(): ?DocumentsModel
    {
        return DocumentsModel::where('type', DocumentTypeEnum::sha->value)->where('status', '1')->whereJsonContains('meta->primary_transactions', $this->id)->latest()->first();
    }

    public function getSsaDocumentAttribute(): ?DocumentsModel
    {
        return DocumentsModel::where('type', DocumentTypeEnum::ssa->value)->where('status', '1')->whereJsonContains('meta->primary_transactions', $this->id)->latest()->first();
    }

    public function getOfferDocumentAttribute(): ?DocumentsModel
    {
        return DocumentsModel::where('type', DocumentTypeEnum::offer->value)->where('status', '1')->whereJsonContains('meta->primary_transactions', $this->id)->latest()->first();
    }

    public function getMgtChallanDocumentAttribute(): ?DocumentsModel
    {
        return DocumentsModel::where('type', DocumentTypeEnum::mgtchallan->value)->where('status', '1')->whereJsonContains('meta->primary_transactions', $this->id)->latest()->first();
    }

    public function getMgtZipDocumentAttribute(): ?DocumentsModel
    {
        return DocumentsModel::where('type', DocumentTypeEnum::mgtzip->value)->where('status', '1')->whereJsonContains('meta->primary_transactions', $this->id)->latest()->first();
    }
    public function getPasZipDocumentAttribute(): ?DocumentsModel
    {
        return DocumentsModel::where('type', DocumentTypeEnum::pas->value)->where('status', '1')->whereJsonContains('meta->primary_transactions', $this->id)->latest()->first();
    }
    public function getCurrentStatusAttribute(): string
    {
        if ($this->type == PrimaryTransactionTypeEnum::captable->value) {
            return self::$currentStatusMapping[$this->status] ?? 'Unknown';
        }
        switch ($this->status) {
            case 2:
                return 'LOI Sent';
            case 3:
                return 'LOI Signed signing completed';
            case 4:
                return 'Completed';
            default:
                return 'Unknown';
        }
    }

    public function getPercentageAttribute()
    {
        if ($this->type == PrimaryTransactionTypeEnum::captable->value) {
            return $this->status * 10;
        }
        return ceil($this->status * 25);
    }

    public function getNextStepAttribute()
    {
        $request = request();
        if ($this->type == PrimaryTransactionTypeEnum::captable->value) {
            if ($this->status == 6) {
                if ($this->lastPayment && $this->lastPayment->status == PaymentStatusEnum::pending->value) {
                    return 'Receipt uploaded Payment approval pending from admin';
                }

                $nextStatus = self::$nextStatusMapping[$this->status][$this->payment_mode == PrimaryTransactionPaymentMode::cheque->value ? 0 : 1];

                if ($request->is('api/*')) {
                    return $nextStatus;
                }

                if (Auth::guard('investor')->check()) {
                    $title = $this->payment_mode == PrimaryTransactionPaymentMode::cheque->value ? 'Counter Slip' : 'Payment Receipt';
                    return '<a href="#" class="uploadPaymentReceipt" data-id="' . $this->id . '" data-title="' . $title . '">
                <i class="fa-solid fa-cloud-arrow-up"></i> Upload ' . $title . '</a>';
                }

                return $nextStatus;
            }
            return self::$nextStatusMapping[$this->status] ?? 'Unknown';
        }
        switch ($this->status) {
            case 2:
                return 'Sign LOI Check your sms for the link from Digiotech Solutions';
            case 3:
                return 'Transaction processing';
            case 4:
                return '-';
            default:
                return 'Unknown';
        }
    }

    protected static $currentStatusMapping = [
        2 => 'SSA Certificate generated',
        3 => 'SSA Certificate signing completed',
        4 => 'MGT-14 uploaded',
        5 => 'Offer Letter Sent',
        6 => 'Offer Letter Signed',
        7 => 'Payment Received',
        8 => 'PAS-3 Uploaded',
        9 => 'SHA Sent',
        10 => 'Completed',
    ];

    protected static $nextStatusMapping = [
        2 => 'Sign SSA Check your sms for the link from Digiotech Solutions',
        3 => 'Waiting for MGT-14 upload',
        4 => 'Waiting for Offer Letter',
        5 => 'Sign Offer Letter Check your sms for the link from Digiotech Solutions',
        6 => ['Upload counter Slip', 'Upload payment receipt'],
        7 => 'Waiting for PAS-3 upload',
        8 => 'Waiting for SHA generation',
        9 => 'Sign SHA Check your sms for the link from Digiotech Solutions',
        10 => '-',
    ];

    public function investorCoupon(): BelongsTo
    {
        return $this->belongsTo(InvestorCouponModel::class, 'investor_coupon_id');
    }
}
