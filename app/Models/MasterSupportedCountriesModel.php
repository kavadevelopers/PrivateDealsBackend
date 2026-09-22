<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterSupportedCountriesModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'flag',
        'is_deleted',
    ];

    protected $table = 'master_supported_countries';
}
