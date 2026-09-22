<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterPagesModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'banner',
        'description',
        'is_display_banner',
        'is_display_title',
        'is_deleted',
    ];

    protected $table = 'master_pages';
}
