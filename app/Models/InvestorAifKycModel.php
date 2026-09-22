<?php

namespace App\Models;

use App\Enums\DocumentTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvestorAifKycModel extends Model
{
    use HasFactory;


    protected $fillable = [
        'investor_id',
        'status',
        'notes',
        'ppm_signed',
        'ca_signed'
    ];

    protected $table = 'investor_aif_kyc';

    function investor(): BelongsTo
    {
        return $this->belongsTo(InvestorModel::class, 'investor_id', 'id');
    }

    protected $appends = ['current_status', 'next_step', 'ppm_document', 'ca_document'];
    function getCurrentStatusAttribute(): string
    {
        switch ($this->status) {
            case 0:
                return 'Pending for verification';
            case 1:
                return 'Rejected';
            case 2:
                if ($this->ppm_signed == 0 && $this->ca_signed == 0) {
                    return 'PPM & CA Sent';
                } else if ($this->ppm_signed == 1 && $this->ca_signed == 0) {
                    return 'PPM Signed, CA Pending';
                } else if ($this->ppm_signed == 0 && $this->ca_signed == 1) {
                    return 'CA Signed, PPM Pending';
                } else {
                    return 'PPM & CA Sent';
                }
            case 3:
                return 'Completed';
            default:
                return 'Unknown';
        }
    }

    function getNextStepAttribute(): string
    {
        switch ($this->status) {
            case 0:
                return 'N/A';
            case 1:
                return 'Re-Upload documents';
            case 2:
                return 'Sign PPM & CA Check your sms for the link from Digiotech Solutions';
            case 3:
                return 'N/A';
            default:
                return 'Unknown';
        }
    }

    public function getPpmDocumentAttribute(): ?DocumentsModel
    {
        return DocumentsModel::where('type', DocumentTypeEnum::ppm->value)->where('status', '1')->whereJsonContains('meta->aif_kyc', $this->id)->first();
    }

    public function getCaDocumentAttribute(): ?DocumentsModel
    {
        return DocumentsModel::where('type', DocumentTypeEnum::ca->value)->where('status', '1')->whereJsonContains('meta->aif_kyc', $this->id)->first();
    }
}
