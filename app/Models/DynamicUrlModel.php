<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DynamicUrlModel extends Model
{
    use HasFactory;

    protected $table = '_dynamic_url';

    protected $fillable = [
        'token',
        'values',
        'token_type',
        'expired'
    ];
}
