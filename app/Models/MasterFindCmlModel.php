<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MasterFindCmlModel extends Model
{
    use HasFactory;

    protected $table = 'find_cmls';

    protected $fillable = [
        'name',
        'logo',
        'description',
        'video',
        'is_deleted'
    ];

    protected $hidden = [
        'uuid',
        'is_deleted',
        'created_at',
        'updated_at'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }
}
