<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteMediaModel extends Model
{
    use HasFactory;
    protected $table = 'website_media';
    protected $fillable = [
        'title',
        'url',
        'banner',
        'description',
        'is_deleted',
    ];
}
