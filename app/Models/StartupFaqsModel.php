<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StartupFaqsModel extends Model
{
    use HasFactory;

    protected $table = 'startup_faqs';

    protected $fillable = [
        'startup_id',
        'question',
        'answer',
    ];

    public function startup(): BelongsTo
    {
        return $this->belongsTo(StartupModel::class, 'startup_id');
    }
}
