<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StartupLegalModel extends Model
{
    use HasFactory;

    protected $table = 'startup_legal';

    protected $fillable = [
        'startup_id',
        'company_name',
        'company_pan',
        'cin',
        'bank_ac_name',
        'bank_name',
        'bank_ac_no',
        'bank_ifsc',
        'bank_uan',
        'dpiit',
        'incorporation_date',
    ];

    // protected $casts = [
    //     'incorporation_date' => 'date',
    // ];

    public function startup(): BelongsTo
    {
        return $this->belongsTo(StartupModel::class, 'startup_id');
    }
}
