<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvestorDematAccountModel extends Model
{
    use HasFactory;

    public function investor(): BelongsTo
    {
        return $this->belongsTo(InvestorModel::class, 'investor_id', 'id');
    }

    protected $fillable = [
        'investor_id',
        'dp_id',
        'client_id',
        'demat_account',
        'document_id',
        'status'
    ];

    protected $hidden = [
        'id',
        'investor_id',
        'created_at',
        'updated_at',
        'status',
        'manage_status'
    ];

    protected $table = 'investor_kyc_demat';
}
