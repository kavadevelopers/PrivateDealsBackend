<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class GlobalSettingModel extends Model
{
    use HasFactory;

    protected $settings;
    protected $keyValuePair;

    public function __construct(Collection $settings)
    {
        $this->settings = $settings;
        foreach ($settings as $setting) {
            $this->keyValuePair[$setting->key] = $setting->value;
        }
    }

    public function has(string $key): void
    { /* check key exists */
    }
    public function contains(string $key): void
    { /* check value exists */
    }
    public function get(string $key): string
    {
        return $this->keyValuePair[$key] ?? '';
    }
}
