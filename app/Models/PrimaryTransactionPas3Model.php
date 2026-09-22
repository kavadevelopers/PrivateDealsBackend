<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrimaryTransactionPas3Model extends Model
{
    use HasFactory;

    protected $table = 'primary_transaction_pas3';
    protected $casts = [
        'meta' => 'object',
    ];
    protected $fillable = [
        'startup_id',
        'round_id',
        'mgt14_id',
        'srn_no',
        'zip',
        'meta',
        'status',
    ];

    public function startup(): BelongsTo
    {
        return $this->belongsTo(StartupModel::class, 'startup_id');
    }

    public function zipDocument(): BelongsTo
    {
        return $this->belongsTo(DocumentsModel::class, 'zip', 'id');
    }
}
