<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MasterStateModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'name',
        'is_deleted',
        'is_new'
    ];

    protected $table = 'master_state';

    protected $hidden = [
        'is_deleted',
        'is_new'
    ];

    public function MasterCity(): HasMany
    {
        return $this->hasMany(MasterCityModel::class, 'id', 'state_id');
    }

    public function MasterCountry(): BelongsTo
    {
        return $this->belongsTo(MasterCountryModel::class, 'country_id', 'id');
    }
}
