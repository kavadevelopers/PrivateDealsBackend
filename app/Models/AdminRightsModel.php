<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminRightsModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    protected $table = '_admin_rights';
}
