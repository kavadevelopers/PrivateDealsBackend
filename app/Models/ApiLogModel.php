<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApiLogModel extends Model
{
    use HasFactory;

    protected $table = 'api_logs';

    protected $fillable = [
        'url',
        'headtoken',
        'deviceid',
        'devicetype',
        'userid',
        'usertype',
        'authorization',
        'useragent',
        'version_code',
        'params',
    ];

    protected $appends = ['user'];


    function getUserAttribute()
    {
        if ($this->userid) {
            if ($this->usertype == 'wealthManager' || $this->usertype == 'distributor') {
                return PartnerModel::where('id', $this->userid)->where('is_deleted', 0)->first();
            }
            if ($this->usertype == 'investor') {
                return InvestorModel::where('id', $this->userid)->where('is_deleted', 0)->first();
            }
        }
        return null;
    }
}
