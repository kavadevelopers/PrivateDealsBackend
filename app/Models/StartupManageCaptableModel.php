<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StartupManageCaptableModel extends Model
{
    use HasFactory;

    protected $table = 'startup_manage_captable';

    protected $fillable = [
        'startup_id',
        'round_id',
        'instrument_type',
        'investor_type',
        'name',
        'email',
        'mobile_number',
        'share',
        'holding_percentage',
        'is_promoter'
    ];
}
