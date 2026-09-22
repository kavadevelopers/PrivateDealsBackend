<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class BseHolidayModel extends Model
{
    protected $table = 'bse_holidays';

    protected $fillable = [
        'uuid',
        'holiday_date',
        'holiday_name',
        'title',
        'holiday_type',
        'holiday_img',
        'is_active',
        'is_deleted',
        'notes',
    ];

    protected $hidden = [
        'uuid',
        'is_deleted',
    ];

    protected $casts = [
        'holiday_date' => 'date',
        'is_active' => 'boolean',
        'is_deleted' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($query) {
            $query->uuid = (string) Str::uuid();
        });
    }

    /**
     * Scope to get only active holidays
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->where('is_deleted', false);
    }

    public function scopeNotDeleted($query)
    {
        return $query->where('is_deleted', false);
    }
    /**
     * Scope to get holidays between dates
     */
    public function scopeBetweenDates($query, $startDate, $endDate)
    {
        return $query->whereBetween('holiday_date', [$startDate, $endDate]);
    }

    /**
     * Scope to get holidays for a specific year
     */
    public function scopeForYear($query, $year)
    {
        return $query->whereYear('holiday_date', $year);
    }

    /**
     * Scope to get holidays for a specific year and month
     */
    public function scopeForMonth($query, $year, $month)
    {
        return $query->whereYear('holiday_date', $year)
            ->whereMonth('holiday_date', $month);
    }
}
