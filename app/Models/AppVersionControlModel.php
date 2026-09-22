<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppVersionControlModel extends Model
{
    use HasFactory;

    protected $table = '_app_version_control';

    protected $fillable = [
        'device',
        'last_version_code',
        'current_version_code',
        'last_version',
        'current_version',
        'force_update',
        'app_type',
        'title',
        'description'
    ];

    protected $casts = [
        'last_version_code' => 'integer',
        'current_version_code' => 'integer',
        'last_version' => 'string',
        'current_version' => 'string',
        'force_update' => 'boolean',
    ];
}
