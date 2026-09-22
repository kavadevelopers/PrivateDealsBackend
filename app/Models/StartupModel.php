<?php

namespace App\Models;

use App\Enums\StartupPrimaryRoundStatusEnum;
use App\Enums\Utills\StatusEnum;
use App\Helpers\AdminHelper;
use App\Helpers\CommonHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class StartupModel extends Authenticatable
{
    use HasFactory, HasApiTokens;

    public function primary_transactions(): HasMany
    {
        return $this->hasMany(PrimaryTransactionModel::class, 'startup_id');
    }
    function cms(): HasOne
    {
        return $this->hasOne(StartupCmsModel::class, 'startup_id');
    }

    function market(): HasMany
    {
        return $this->hasMany(SecondarySellRequestModel::class, 'startup_id')->where('status', '7');
    }

    function portfolio(): HasMany
    {
        return $this->hasMany(PortfolioModel::class, 'startup_id');
    }

    function faqs(): HasMany
    {
        return $this->hasMany(StartupFaqsModel::class, 'startup_id');
    }

    function socialMediaLinks(): HasMany
    {
        return $this->hasMany(StartupSocialMediaModel::class, 'startup_id');
    }

    function pitches(): HasMany
    {
        return $this->hasMany(StartupPitchModel::class, 'startup_id');
    }

    function updates(): HasMany
    {
        return $this->hasMany(StartupUpdateModel::class, 'startup_id');
    }

    function misDocs(): HasMany
    {
        return $this->hasMany(StartupMisModel::class, 'startup_id');
    }

    function approvedMis(): HasMany
    {
        return $this->hasMany(StartupMisModel::class, 'startup_id')->where('status', StatusEnum::approved);
    }

    function sharePrices(): HasMany
    {
        return $this->hasMany(StartupSharePriceModel::class, 'startup_id');
    }

    function rounds(): HasMany
    {
        return $this->hasMany(StartupRoundModel::class, 'startup_id');
    }

    function offerrequest(): HasMany
    {
        return $this->hasMany(StartupOfferRequestModel::class, 'startup_id');
    }

    function lastRounds(): HasOne
    {
        return $this->hasOne(StartupRoundModel::class, 'startup_id')->orderby('id', 'desc');
    }

    function raising_round(): HasOne
    {
        return $this->hasOne(StartupRoundModel::class, 'startup_id')->where('round_status', StartupPrimaryRoundStatusEnum::raisingnow)->orderby('id', 'desc');
    }

    function teamMembers(): HasMany
    {
        return $this->hasMany(StartupTeamModel::class, 'startup_id');
    }

    function legalInfo(): HasOne
    {
        return $this->hasOne(StartupLegalModel::class, 'startup_id');
    }
    function legalInfoOne(): BelongsTo
    {
        return $this->belongsTo(StartupLegalModel::class, 'startup_id')->orderby('id', 'desc');
    }

    function details(): HasOne
    {
        return $this->hasOne(StartupDetailsModel::class, 'startup_id');
    }

    function city(): BelongsTo
    {
        return $this->belongsTo(MasterCityModel::class, 'city_id', 'id');
    }

    function country(): BelongsTo
    {
        return $this->belongsTo(MasterCountryModel::class, 'country_id', 'id');
    }

    function state(): BelongsTo
    {
        return $this->belongsTo(MasterStateModel::class, 'state_id', 'id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(UserAdminModel::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(UserAdminModel::class, 'updated_by');
    }

    public function StartupFundRaise(): HasMany
    {
        return $this->hasMany(StartupFundRaiseModel::class, 'startup_id', 'id');
    }
    public function StartupFundRaiseOne(): HasOne
    {
        return $this->hasOne(StartupFundRaiseModel::class, 'startup_id', 'id')->orderby('id', 'desc');
    }
    public function StartupFinance(): HasMany
    {
        return $this->hasMany(StartupFinancialDetailModel::class, 'startup_id', 'id');
    }
    public function StartupOther(): HasMany
    {
        return $this->hasMany(StartupOtherDetailModel::class, 'startup_id', 'id');
    }
    public function StartupOtherOne(): HasOne
    {
        return $this->hasOne(StartupOtherDetailModel::class, 'startup_id', 'id')->orderby('id', 'desc');
    }
    public function StartupDocumentOne(): HasOne
    {
        return $this->hasOne(StartupDetailsModel::class, 'startup_id', 'id')->orderby('id', 'desc');
    }
    public function StartupKeyMetricsOne(): HasOne
    {
        return $this->hasOne(StartupKeyMetricsModel::class, 'startup_id', 'id')->orderby('id', 'desc');
    }

    public function industry(): BelongsTo
    {
        return $this->belongsTo(MasterIndustryModel::class, 'industry_segment', 'id');
    }

    public function sector(): BelongsTo
    {
        return $this->belongsTo(MasterSectorsModel::class, 'sector_id', 'id');
    }

    public function startupDocument(): HasMany
    {
        return $this->hasMany(StartupDocumentModel::class, 'startup_id');
    }

    protected $table = 'startup';

    protected $fillable = [
        'uuid',
        'url_slug',
        'brand_name',
        'sector_id',
        'industry_segment',
        'city_id',
        'state_id',
        'country_id',
        'company_name',
        'mobile_country_code',
        'mobile_number',
        'email',
        'brief_information',
        'address',
        'pincode',
        'bg_color_code',
        'representative_name',
        'representative_pan',
        'representative_address',
        'password',
        'registration_step',
        'is_fake',
        'is_verified_mobile',
        'is_verified_email',
        'ask_password_change',
        'status',
        'is_active',
        'is_blocked',
        'is_deleted',
        'created_by',
        'updated_by',
        'indicative_valuation'
    ];

    protected $appends = [
        'is_favorite',
        'investor_count',
        'available_shares',
        'share_prices_array',
        'minimum_shares'
    ];

    public function getIsFavoriteAttribute()
    {
        $userId = CommonHelper::getUserFromSanctum();
        if ($userId) {
            return InvestorFavStartupModel::where('investor_id', $userId)->where('startup_id', $this->id)->exists();
        }
        // $request = request();
        // if ($request) {
        //     $user = $request->user();
        //     if ($user) {
        //         return InvestorFavStartupModel::where('investor_id', $user->id)->where('startup_id', $this->id)->exists();
        //     }
        // }
        // if (Auth::guard('investor')->check()) {
        //     return InvestorFavStartupModel::where('investor_id', Auth::guard('investor')->user()->id)->where('startup_id', $this->id)->exists();
        // }
        return false;
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($query) {
            $query->uuid = (string) Str::uuid();
        });

        static::saving(function ($startup) {
            if (!empty($startup->url_slug)) {
                return;
            }

            $name = $startup->brand_name ?: $startup->company_name;
            if (!$name) {
                return;
            }

            $startup->url_slug = AdminHelper::startupSlug($name, $startup->id ?: false);
        });
    }

    public function getInvestorCountAttribute(): int
    {
        return
            PortfolioModel::where('startup_id', $this->id)
            ->distinct('investor_id')
            ->count('investor_id');
    }

    public function getAvailableSharesAttribute(): int
    {
        $list = SecondarySellRequestModel::where('startup_id', $this->id)->select('id', 'shares')->where('status', 7)->get();
        $totalAvailable = $list->sum('shares');
        $sharesSold = 0;
        foreach ($list as $key => $item) {
            $sharesSold += SecondaryTransactionModel::select('shares', 'status')->whereNotIn('status', [2, 3])->where('sell_request_id', $item->id)->get()->sum('shares');
        }
        return $totalAvailable - $sharesSold;
    }

    public function getSharePricesArrayAttribute(): array
    {
        $sharePricesFromModel = $this->sharePrices()
            ->orderBy('created_at', 'asc')
            ->pluck('price')  // Assuming 'price' is the column name
            ->toArray();

        // Get the share prices from the rounds relation, ordered by created_at
        // $sharePricesFromRounds = $this->rounds()
        //     ->orderBy('created_at', 'asc')
        //     ->pluck('share_price')
        //     ->toArray();

        // Merge the two arrays of share prices
        // $combinedSharePrices = array_merge($sharePricesFromRounds, $sharePricesFromModel);

        return $sharePricesFromModel;
    }

    function getMinimumSharesAttribute(): int
    {
        $minSharesFromCaptable = StartupManageCaptableModel::where('startup_id', $this->id)
            ->min('share') ?? 0;

        if (is_null($minSharesFromCaptable)) {
            return PortfolioModel::where('startup_id', $this->id)->min('shares') ?? 0;
        }

        return $minSharesFromCaptable;
    }
}
