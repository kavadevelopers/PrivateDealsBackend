<?php

namespace App\Models;

use App\Helpers\AdminHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MasterSectorsModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'industry_id',
        'name',
        'icon_image',
        'url_slug',
        'display_order',
        'is_deleted',
    ];

    protected $table = 'master_sectors';

    protected $hidden = [
        'display_order',
        'is_deleted',
        'created_at',
        'updated_at'
    ];

    protected $appends = [
        'slug',
    ];

    public function getSlugAttribute(): ?string
    {
        return $this->attributes['url_slug'] ?? $this->url_slug;
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($sector) {
            if (!empty($sector->url_slug) || empty($sector->name)) {
                return;
            }

            $sector->url_slug = AdminHelper::sectorSlug(strtolower($sector->name), $sector->id ?: false);
        });
    }

    public function startups(): HasMany
    {
        return $this->hasMany(StartupModel::class, 'sector_id')->where('is_deleted', 0);
    }

    public function companies(): HasMany
    {
        return $this->hasMany(CompanyModel::class, 'sector_id');
    }

    public function MasterIndustry(): BelongsTo
    {
        return $this->belongsTo(MasterIndustryModel::class, 'industry_id', 'id');
    }
}
