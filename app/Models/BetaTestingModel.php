<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BetaTestingModel extends Model
{
    use HasFactory;

    protected $table = 'beta_testing';

    protected $fillable = [
        'email'
    ];
}
