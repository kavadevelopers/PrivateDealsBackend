<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempAadharPanDetailsModel extends Model
{
    use HasFactory;

    protected $table = 'temp_aadhar_pan_details';

    protected $fillable = [
        'investor_id',
        'aadhar_front',
        'aadhar_back',
        'pan',
        'aadhar_no',
        'pan_no',
        'aadhar_name',
        'pan_name',
        'dob',
        'address',
    ];

    public function investor()
    {
        return $this->belongsTo(InvestorModel::class, 'investor_id');
    }
}
