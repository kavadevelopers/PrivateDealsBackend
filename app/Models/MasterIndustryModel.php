<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MasterIndustryModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'icon_image',
        'url_slug',
        'display_order',
        'is_deleted',
    ];

    protected $table = 'master_industry';

    public function MasterSectors(): HasMany
    {
        return $this->hasMany(MasterSectorsModel::class, 'id', 'industry_id');
    }
}
