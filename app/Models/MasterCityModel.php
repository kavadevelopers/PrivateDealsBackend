<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use PhpOffice\PhpSpreadsheet\Writer\Ods\Thumbnails;

class MasterCityModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'state_id',
        'name',
        'is_deleted',
        'is_new'
    ];

    protected $table = 'master_city';

    protected $hidden = [
        'is_deleted',
        'is_new'
    ];

    public function MasterState(): BelongsTo
    {
        return $this->belongsTo(MasterStateModel::class, 'state_id', 'id');
    }

    public function MasterCountry(): BelongsTo
    {
        return $this->belongsTo(MasterCountryModel::class, 'country_id', 'id');
    }
}
