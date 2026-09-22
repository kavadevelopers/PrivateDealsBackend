<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyGrabOpportunitySlotModel extends Model
{
    protected $table = 'company_grab_opportunity_slots';

    protected $fillable = [
        'company_id',
        'slot_number',
        'min_amount',
        'max_amount',
        'percentage'
    ];

    protected $hidden = [
        'id',
        'company_id',
        'created_at',
        'updated_at'
    ];

    /**
     * Get the company that owns the grab opportunity slot.
     * 
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(CompanyModel::class, 'company_id');
    }
}
