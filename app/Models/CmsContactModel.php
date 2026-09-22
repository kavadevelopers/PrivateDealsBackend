<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmsContactModel extends Model
{
    use HasFactory;

    protected $table = 'cms_contact';

    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'mobile_no',
        'description',
        'company',
        'subject',
        'user_type',
        'user_id',
        'is_deleted',
    ];
}
