<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResourceBillingModel extends Model
{
    use HasFactory;

    protected $table = 'resource_billing';

    protected $fillable = [
        'project_id',
        'resource_type',
        'company',
        'description',
        'purchase_date',
        'renewal_date',
        'status',
        'time_period',
        'is_recurring',
        'amount',
        'renewal_amount',
    ];

    public function projects(): BelongsTo
    {
        return $this->belongsTo(MasterProjectsModel::class, 'project_id');
    }
}
