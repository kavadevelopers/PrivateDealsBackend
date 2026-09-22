<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestorKycPanModel extends Model
{
    use HasFactory;

    protected $table = 'investor_kyc_pan';

    protected $fillable = [
        'investor_id',
        'pan_no',
        'pan_name',
        'dob',
        'status',
        'document_id'
    ];

    protected $hidden = [
        'id',
        'investor_id',
        'created_at',
        'updated_at',
        'status',
        'document_id'
    ];

    public function investor()
    {
        return $this->belongsTo(InvestorModel::class, 'investor_id');
    }
}
