<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterProjectsModel extends Model
{
    use HasFactory;

    protected $table = 'master_projects';

    protected $fillable = [
        'project_name',
        'is_deleted',
    ];
    
}
