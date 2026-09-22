<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StartupDetailsModel extends Model
{
    use HasFactory;

    protected $table = 'startup_details';

    protected $fillable = [
        'startup_id',
        'short_description',
        'info_description',
        'key_information',
        'logo',
        'banner',
        'pitch_deck_file',
        'long_banner',
        'product_video',
        'dpiit_startup_certificate',
        'website_url',
    ];

    public function startup(): BelongsTo
    {
        return $this->belongsTo(StartupModel::class, 'startup_id');
    }
}
