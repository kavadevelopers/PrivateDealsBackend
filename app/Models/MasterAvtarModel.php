<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MasterAvtarModel extends Model
{
    use HasFactory;

    protected $table = 'master_avtar';

    protected $fillable = [
        'uuid',
        'avtar_img',
        'display_order',
        'is_deleted',

    ];

    protected $hidden = [
        'uuid',
        'display_order',
        'is_deleted',
    ];
    
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($query) {
            $query->uuid = (string) Str::uuid();
        });
    }
}
