<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentsSignersModel extends Model
{
    use HasFactory;

    protected $table = 'documents_signers';

    protected $fillable = [
        'document_id',
        'user_id',
        'user_type',
        'identifier',
        'identifier_value',
        'sign_type',
        'is_signed',
        'link',
        'expire_on'
    ];

    public function document(): BelongsTo
    {
        return $this->belongsTo(DocumentsModel::class,'document_id');
    }
}
