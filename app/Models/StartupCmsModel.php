<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StartupCmsModel extends Model
{
    use HasFactory;

    protected $table = 'startup_cms';

    protected $fillable = [
        'startup_id',
        'logo',
        'banner',
        'long_banner',
        'product_video',
        'pitch_video',
        'pitch_deck',
        'financial_projection',
        'dd_report',
        'dpiit_report',
        'shuruup_research_report',
        'valuation_report',
        'one_liner',
        'highlights',
        'website',
        'idea',
        'key_information',
    ];

    public function startup(): BelongsTo
    {
        return $this->belongsTo(StartupModel::class, 'startup_id');
    }
}
