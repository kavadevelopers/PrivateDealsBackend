<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportErrorLogModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'subtype',
        'description',
        'notes'
    ];

    protected $table = 'report_error_logs';
}
