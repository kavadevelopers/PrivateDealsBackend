<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyCustomDataModel extends Model
{
    use HasFactory;

    protected $table = 'company_custom_data';

    protected $fillable = [
        'company_id',
        'label',
        'values'
    ];

    protected $hidden = [
        'id',
        'company_id',
        'created_at',
        'updated_at'
    ];
}
