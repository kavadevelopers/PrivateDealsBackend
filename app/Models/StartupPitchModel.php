<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class StartupPitchModel extends Model
{
    use HasFactory;

    protected $table = 'startup_pitch';

    protected $fillable = [
        'uuid',
        'startup_id',
        'startup_round_id',
        'title',
        'description',
        'scheduled_date',
        'host_url',
        'user_url',
        'video_url',
        'status',
        'created_by',
        'updated_by',
        'is_deleted'
    ];

    // protected $casts = [
    //     'date' => 'date',
    //     'time' => 'datetime',
    //     'datetime' => 'datetime',
    // ];

    protected $hidden = [
        'uuid',
        'created_by',
        'updated_by',
        'is_deleted',
    ];

    public function startup(): BelongsTo
    {
        return $this->belongsTo(StartupModel::class, 'startup_id');
    }

    public function startupRound(): BelongsTo
    {
        return $this->belongsTo(StartupRoundModel::class, 'startup_round_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(UserAdminModel::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(UserAdminModel::class, 'updated_by');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($query) {
            $query->uuid = (string) Str::uuid();
        });
    }
}
