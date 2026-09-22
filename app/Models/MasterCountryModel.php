<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MasterCountryModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_deleted'
    ];

    protected $hidden = [
        'is_deleted'
    ];

    protected $table = 'master_country';

    public function MasterState(): HasMany
    {
        return $this->hasMany(MasterStateModel::class, 'id', 'country_id');
    }

    public function MasterCity(): HasMany
    {
        return $this->hasMany(MasterCityModel::class, 'id', 'country_id');
    }
}
