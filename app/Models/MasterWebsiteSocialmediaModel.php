<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterWebsiteSocialmediaModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'icon',
        'link',
        'display_order',
        'is_deleted',
    ];

    protected $table = 'master_website_social_media';
}
