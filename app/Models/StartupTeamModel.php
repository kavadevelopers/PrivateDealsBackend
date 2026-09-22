<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StartupTeamModel extends Model
{
    protected $table = 'startup_team';

    protected $fillable = [
        'startup_id',
        'name',
        'designation',
        'brief_information',
        'profile_photo',
        'linkedin_url',
    ];

    public function startup(): BelongsTo
    {
        return $this->belongsTo(StartupModel::class, 'startup_id');
    }
}
