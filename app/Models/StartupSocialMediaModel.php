<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StartupSocialMediaModel extends Model
{
    use HasFactory;

    protected $table = 'startup_social_media';

    protected $fillable = [
        'startup_id',
        'master_socialmedia_link_id',
        'link',
    ];

    public function startup(): BelongsTo
    {
        return $this->belongsTo(StartupModel::class, 'startup_id');
    }

    public function socialMediaType(): BelongsTo
    {
        return $this->belongsTo(MasterSocialmediaLinkModel::class, 'master_socialmedia_link_id');
    }
}
