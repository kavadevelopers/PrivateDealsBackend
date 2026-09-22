<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BankDetailsModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_id',
        'account_holder_name',
        'account_number',
        'ifsc_code',
        'status',
        'user_id',
        'user_type',
        'is_deleted',
    ];

    protected $table = 'bank_details';

    protected $hidden = ['user_id', 'user_type', 'is_deleted'];

    public function bank(): BelongsTo
    {
        return $this->belongsTo(MasterBankModel::class, 'bank_id', 'id');
    }
}
