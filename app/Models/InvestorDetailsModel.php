<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestorDetailsModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'investor_id',
        'investor_company',
        'investor_company_position',
        'investor_bio',
        'facebook_link',
        'twitter_link',
        'instagram_link',
        'linked_in_link',
        'website_link',
        'date_of_birth'
    ];

    protected $table = 'investor_details';
}
