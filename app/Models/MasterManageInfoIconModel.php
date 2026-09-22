<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterManageInfoIconModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'sub_title',
        'link_name',
        'link',
        'description'
    ];

    protected $table = 'master_manage_info_icon';
}
