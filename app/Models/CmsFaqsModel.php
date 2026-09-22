<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CmsFaqsModel extends Model
{
    use HasFactory;

    protected $table = 'cms_faqs';

    protected $fillable = [
        'uuid',
        'question',
        'answer',
        'category',
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
