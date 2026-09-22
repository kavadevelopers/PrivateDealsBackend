<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInvestorModel extends Model
{
    use HasFactory;

    protected $table = 'investor';

    protected $fillable = [
        'partner_id',
        'parent_investor_id',
        'family_relation_id',
        'investor_type',
        'name',
        'mobile_country_code',
        'mobile_number',
        'email',
        'address',
        'city_id',
        'state_id',
        'country_id',
        'pincode',
        'gender',
        'profile_photo',
        'password',
        'profile_visibility',
        'registration_step',
        'kyc_status',
        'aadhar_verified_type',
        'is_fake_investor',
        'is_verified_mobile',
        'is_verified_email',
        'ask_password_change',
        'is_active',
        'is_blocked',
        'is_deleted',
        'created_by',
        'updated_by',
    ];
}
