<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ApiTokenForHeaderAuthModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'token',
        'is_deleted',
        'created_by',
        'updated_by'
    ];

    protected $table = '_api_tokens_for_header_auth';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = Auth::guard('admin')->user()->id;
            $model->updated_by = Auth::guard('admin')->user()->id;
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::guard('admin')->user()->id;
        });
    }
}
