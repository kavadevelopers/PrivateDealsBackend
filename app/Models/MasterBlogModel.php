<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterBlogModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'banner',
        'title',
        'url_slug',
        'short_description',
        'long_description',
        'display_order',
        'is_deleted',
    ];

    protected $table = 'master_blog';

    protected $hidden = [
        'is_deleted',
    ];
}
