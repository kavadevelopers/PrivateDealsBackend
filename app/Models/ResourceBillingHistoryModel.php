<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResourceBillingHistoryModel extends Model
{
    use HasFactory;

    protected $table = 'resource_billing_history';

    protected $fillable = [
        'resource_billing_id',
        'file',
        'purchase_date',
        'expire_date',
        'amount',
        'renewal_amount',
    ];

    public function resourceBilling()
    {
        return $this->belongsTo(ResourceBillingModel::class, 'resource_billing_id');
    }
}
