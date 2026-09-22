<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CompanyShareHolderModel extends Model
{
    use HasFactory;

    protected $table = 'company_share_holder';

    // Define the fillable attributes
    protected $fillable = [
        'company_id',
        'name',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(CompanyModel::class, 'company_id');
    }

    public function sharePercentage(): HasMany
    {
        return $this->hasMany(CompanyShareHolderPercentageModel::class, 'share_holder_id');
    }
}
