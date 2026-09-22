<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvestorMandatesModel extends Model
{
    use HasFactory;

    protected $table = 'investor_mandates';

    protected $fillable = [
        'investor_id',
        'mandate_id',
        'bank_id',
        'umrn_no',
        'state',
        'amount',
        'bank_account_no',
        'bank_account_type',
        'bank_ifsc_code',
    ];

    public function bank():BelongsTo
    {
        return $this->belongsTo(MasterBankModel::class, 'bank_id', 'id');
    }
}
