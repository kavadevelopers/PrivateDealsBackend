<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmsFeedbackModel extends Model
{
    use HasFactory;

    protected $table = 'cms_feedback';

    protected $fillable = [
        'type',
        'name',
        'email',
        'description'
    ];
}
