<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class CompanyNewsModel extends Model
{
    use HasFactory;

    protected $table = 'company_news';

    protected $fillable = [
        'company_id',
        'image',
        'title',
        'description',
        'link',
    ];

    protected $hidden = [
        'updated_at'
    ];

    protected $appends = [
        'platform_name',
    ];

    protected function platformName(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->link) {
                    return null;
                }

                $host = parse_url($this->link, PHP_URL_HOST); // e.g. www.business-standard.com
                if (!$host) {
                    return null;
                }

                // remove leading www.
                $host = preg_replace('/^www\./i', '', $host);

                // optional: convert "business-standard.com" -> "Business Standard"
                $name = preg_replace('/\.[a-z.]+$/i', '', $host); // remove TLD (.com, .in, .co.in, etc.)
                $name = str_replace(['-', '_'], ' ', $name);
                $name = ucwords($name);

                return $name;
            }
        );
    }
    /**
     * Get the company that owns the events.
     * 
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(CompanyModel::class, 'company_id');
    }
}
