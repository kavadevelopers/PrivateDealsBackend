<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempDematCmlFiles extends Model
{
    use HasFactory;

    protected $table = 'temp_demat_cml_files';

    protected $fillable = [
        'investor_id',
        'file_path',
        'original_name',
        'reason',
    ];
}
