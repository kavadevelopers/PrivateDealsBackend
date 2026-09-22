<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterStartupRoundTypeModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_deleted'
    ];

    protected $table = 'master_startup_round_type';
}
