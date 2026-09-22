<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppSettingsModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value'
    ];
    protected $table = 'app_settings';
}
