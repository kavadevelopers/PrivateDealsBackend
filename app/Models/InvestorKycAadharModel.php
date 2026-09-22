<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestorKycAadharModel extends Model
{
    use HasFactory;

    protected $table = 'investor_kyc_aadhar';

    protected $fillable = [
        'investor_id',
        'aadhar_no',
        'aadhar_name',
        'dob',
        'address',
        'status',
        'front_document_id',
        'back_document_id'
    ];

    public function investor()
    {
        return $this->belongsTo(InvestorModel::class, 'investor_id');
    }

    protected $hidden = [
        'id',
        'investor_id',
        'created_at',
        'updated_at',
        'status',
        'front_document_id',
        'back_document_id'
    ];
}
