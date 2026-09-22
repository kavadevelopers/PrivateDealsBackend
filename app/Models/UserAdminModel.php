<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class UserAdminModel  extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $table = 'user_admin';

    protected $fillable = [
        'uuid',
        'role',
        'name',
        'username',
        'mobile_no',
        'email',
        'password',
        'profile_photo_path',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($query) {
            $query->uuid = (string) Str::uuid();
        });
    }

    public function investors(): HasMany
    {
        return $this->hasMany(InvestorModel::class, 'created_by');
    }
}
