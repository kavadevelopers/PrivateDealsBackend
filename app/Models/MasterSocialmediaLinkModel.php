<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterSocialmediaLinkModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'icon',
        'is_deleted',
    ];

    protected $table = 'master_social_media_links';
}
