<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class SellerMasterModel extends Authenticatable
{
    use HasFactory, HasApiTokens;

    protected $table = 'seller_master';

    protected $fillable = [
        'cin',
        'pan',
        'company_name',
        'logo',
        'address',
        'dp_id',
        'client_id',
        'bank_name',
        'account_number',
        'ifsc',
        'branch',
        'mobile_country_code',
        'mobile_number',
        'email',
        'password',
        'is_blocked',
        'ask_password_change',
        'is_primary_access',
        'is_secondary_access',
        'is_preipo_access',
        'is_deleted',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'account_number' => 'string',
        'is_primary_access' => 'boolean',
        'is_secondary_access' => 'boolean',
        'is_preipo_access' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($query) {
            $query->uuid = (string) Str::uuid();
        });
    }

    public function companySharePrices(): HasMany
    {
        return $this->hasMany(SellerCompanySharePriceModel::class, 'seller_id');
    }
}
