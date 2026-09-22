<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StartupDocumentModel extends Model
{
    // The table associated with the model
    protected $table = 'startup_details';

    // The primary key associated with the table
    protected $primaryKey = 'id';

    // Indicates if the model should be timestamped.
    public $timestamps = true;

    // Fillable fields for mass assignment
    protected $fillable = [
        'startup_id',
        'pitch_deck',
        'fina_projection',
        'dd_report',
        'vreport',
        'dpiit_file',
        'long_banner',
        'banner',
        'logo',
        'product_video',
        'pitch_video',
    ];

    public function startup(): BelongsTo
    {
        return $this->belongsTo(StartupModel::class, 'startup_id');
    }
}
