<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class InvestorKycModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'investor_id',
        'aadhar_no',
        'pan_no',
        'name_as_aadhar',
        'dob_as_aadhar',
        'address_as_aadhar',
        'name_as_pan',
        'aadhaar_front_image',
        'aadhaar_back_image',
        'pan_image',
        'cml_image',
        'cheque_image',
        'notes',
        'status',
        'created_by',
        'updated_by'
    ];

    protected $table = 'investor_kyc';

    function investor(): BelongsTo
    {
        return $this->belongsTo(InvestorModel::class, 'investor_id', 'id');
    }

    protected $hidden = [
        'investor_id',
        'pan_no',
        'name_as_pan',
        'notes',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];
}
