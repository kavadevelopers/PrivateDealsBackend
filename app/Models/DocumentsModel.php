<?php

namespace App\Models;

use App\Enums\DocumentTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class DocumentsModel extends Model
{
    use HasFactory;

    protected $table = 'documents';

    protected $fillable = [
        'api_id',
        'path',
        'signed_path',
        'status',
        'type',
        'meta',
    ];

    protected $casts = [
        'meta' => 'object',
    ];

    protected $appends = ['display_name'];

    public function getDisplayNameAttribute(): string
    {
        if (Auth::guard('startup')->check()) {
            return $this->meta->sname;
        } else {
            return $this->meta->name;
        }
    }

    public function zipTransactions(): HasMany
    {
        return $this->hasMany(PrimaryTransactionMgt14Model::class, 'zip', 'id');
    }

    public function challanTransactions(): HasMany
    {
        return $this->hasMany(PrimaryTransactionMgt14Model::class, 'challan', 'id');
    }

    public function signers(): HasMany
    {
        return $this->hasMany(DocumentsSignersModel::class, 'document_id', 'id');
    }
}
