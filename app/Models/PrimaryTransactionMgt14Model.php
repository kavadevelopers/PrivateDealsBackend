<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PrimaryTransactionMgt14Model extends Model
{
    use HasFactory;

    protected $table = 'primary_transaction_mgt14';

    protected $fillable = [
        'startup_id',
        'round_id',
        'srn_no',
        'zip',
        'challan',
        'meta',
        'status',
    ];

    protected $casts = [
        'meta' => 'object',
    ];

    public function startup(): BelongsTo
    {
        return $this->belongsTo(StartupModel::class, 'startup_id');
    }

    public function zipDocument(): BelongsTo
    {
        return $this->belongsTo(DocumentsModel::class, 'zip', 'id');
    }

    public function challanDocument(): BelongsTo
    {
        return $this->belongsTo(DocumentsModel::class, 'challan', 'id');
    }
    public function primaryTransactionsOne(): HasOne
    {
        return $this->hasOne(PrimaryTransactionModel::class, 'mgt14_id')->orderby('id', 'desc');
    }
    public function primaryTransactions(): HasMany
    {
        return $this->hasMany(PrimaryTransactionModel::class, 'mgt14_id');
    }
}
