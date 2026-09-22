<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ApiClient extends Model
{
    use HasFactory;
    protected $table = 'api_clients';
    protected $fillable = ['name', 'token', 'allowed_domains', 'is_ai', 'description', 'is_deleted'];

    protected $casts = [
        'is_ai' => 'boolean',
    ];

    public function isAi(): bool
    {
        return (bool) $this->is_ai;
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($query) {
            $query->uuid = (string) Str::uuid();
        });
    }
}
