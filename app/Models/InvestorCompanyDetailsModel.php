<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestorCompanyDetailsModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'investor_id',
        'incorporation_date',
        'din_of_director',
        'rofllphuf',
        'pan_of_karta'
    ];

    protected $table = 'investor_company_details';
}
