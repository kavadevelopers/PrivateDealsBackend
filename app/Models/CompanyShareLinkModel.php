<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyShareLinkModel extends Model
{
    use HasFactory;

    protected $table = 'company_share_links';

    protected $fillable = [
        'investor_id',
        'type',
        'company_uuid',
        'deep_link',
    ];
}
