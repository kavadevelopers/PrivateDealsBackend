<?php

namespace App\Models;

use App\Enums\TempCompanyIntentEnum;
use App\Enums\TempCompanyStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class TempCompanyModel extends Model
{
    protected $table = 'temp_company';

    protected $fillable = [
        'uuid',
        'external_ref',
        'api_client_id',
        'matched_company_id',
        'intent',
        'status',
        'cin',
        'brand_name',
        'company_name',
        'about',
        'logo',
        'logo_url',
        'keywords',
        'negative_keywords',
        'alternative_names',
        'type',
        'is_drhp',
        'category',
        'bg_color_code',
        'sector_name',
        'sector_id',
        'min_investment_amount',
        'commission',
        'processing_fee_percentage',
        'fundamentals',
        'promoters',
        'shareholders',
        'events',
        'financials',
        'raw_payload',
        'admin_notes',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'fundamentals' => 'array',
        'promoters' => 'array',
        'shareholders' => 'array',
        'events' => 'array',
        'financials' => 'array',
        'raw_payload' => 'array',
        'reviewed_at' => 'datetime',
        'is_drhp' => 'boolean',
        'min_investment_amount' => 'decimal:2',
        'commission' => 'decimal:2',
        'processing_fee_percentage' => 'decimal:2',
        'status' => TempCompanyStatusEnum::class,
        'intent' => TempCompanyIntentEnum::class,
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($query) {
            if (empty($query->uuid)) {
                $query->uuid = (string) Str::uuid();
            }
        });
    }

    public function apiClient(): BelongsTo
    {
        return $this->belongsTo(ApiClient::class, 'api_client_id');
    }

    public function matchedCompany(): BelongsTo
    {
        return $this->belongsTo(CompanyModel::class, 'matched_company_id');
    }

    public function sector(): BelongsTo
    {
        return $this->belongsTo(MasterSectorsModel::class, 'sector_id');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(UserAdminModel::class, 'reviewed_by');
    }

    public static function normalizeCin(?string $cin): ?string
    {
        if ($cin === null || trim($cin) === '') {
            return null;
        }

        return strtoupper(preg_replace('/\s+/', '', trim($cin)));
    }
}
