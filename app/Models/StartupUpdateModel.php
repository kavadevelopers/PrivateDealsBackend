<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\Utills\StatusEnum as UtillsStatusEnum;

class StartupUpdateModel extends Model
{
    use HasFactory;

    protected $table = 'startup_updates';

    protected $fillable = [
        'startup_id',
        'title',
        'description',
        'image',
        'status',
    ];

    protected $casts = [
        'status' => UtillsStatusEnum::class,
    ];

    public function startup(): BelongsTo
    {
        return $this->belongsTo(StartupModel::class, 'startup_id');
    }
}
