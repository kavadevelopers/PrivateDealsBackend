<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DematManualModel extends Model
{
    use HasFactory;

    protected $table = 'demat_manual';

    protected $fillable = [
        'investor_id',
        'document_id',
        'status',
        'reason',
    ];

    public function document()
    {
        return $this->belongsTo(DocumentsModel::class, 'document_id');
    }

    public function investor()
    {
        return $this->belongsTo(InvestorModel::class, 'investor_id');
    }
}
