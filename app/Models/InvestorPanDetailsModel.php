<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestorPanDetailsModel extends Model
{
    use HasFactory;
    protected $fillable = [
        'investor_id',
        'pan_no',
        'name_as_pan',
        'pan_image',
        'status'
    ];
    protected $table = 'investor_pan_details';
    protected $hidden = [
        'investor_id',
    ];
}
