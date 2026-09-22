<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyShareHolderPercentageModel extends Model
{
    use HasFactory;

    protected $table = 'company_share_holder_percentage';

    protected $fillable = [
        'company_id',
        'share_holder_id',
        'year',
        'percentage'
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(CompanyModel::class, 'company_id');
    }

    public function shareHolder(): BelongsTo
    {
        return $this->belongsTo(CompanyShareHolderModel::class, 'share_holder_id');
    }
}
