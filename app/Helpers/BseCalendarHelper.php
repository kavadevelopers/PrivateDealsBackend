<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Models\BseHolidayModel;

class BseCalendarHelper
{
    /**
     * Cache key for BSE holidays
     */
    private const CACHE_KEY = 'bse_holidays_active';

    /**
     * Cache duration in minutes (24 hours)
     */
    private const CACHE_DURATION = 24 * 60;

    /**
     * Check if a date is a weekend (Saturday or Sunday)
     *
     * @param Carbon $date
     * @return bool
     */
    public static function isWeekend(Carbon $date): bool
    {
        return $date->isWeekend();
    }

    /**
     * Check if a date is a BSE holiday (cached)
     *
     * @param Carbon $date
     * @return bool
     */
    public static function isBseHoliday(Carbon $date): bool
    {
        $holidays = self::getActiveHolidayDates();
        return in_array($date->format('Y-m-d'), $holidays);
    }

    /**
     * Get all active holiday dates from database with caching
     *
     * @return array
     */
    private static function getActiveHolidayDates(): array
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_DURATION, function () {
            return BseHolidayModel::active()
                ->pluck('holiday_date')
                ->map(fn($date) => $date->format('Y-m-d'))
                ->toArray();
        });
    }

    /**
     * Get all active holidays
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getActiveHolidays()
    {
        return BseHolidayModel::active()->orderBy('holiday_date')->get();
    }

    /**
     * Get holidays for a specific year
     *
     * @param int $year
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getHolidaysForYear($year)
    {
        return BseHolidayModel::active()
            ->forYear($year)
            ->orderBy('holiday_date')
            ->get();
    }

    /**
     * Add a new holiday
     *
     * @param string $date (YYYY-MM-DD format)
     * @param string $name
     * @param string $type (national, regional, market_closure, special)
     * @param string|null $notes
     * @return BseHolidayModel
     */
    public static function addHoliday($date, $name, $type = 'market_closure', $notes = null)
    {
        $holiday = BseHolidayModel::create([
            'holiday_date' => $date,
            'holiday_name' => $name,
            'holiday_type' => $type,
            'is_active' => true,
            'notes' => $notes,
        ]);

        self::invalidateCache();

        return $holiday;
    }

    /**
     * Toggle holiday active status
     *
     * @param int $holidayId
     * @param bool $isActive
     * @return bool
     */
    public static function toggleHoliday($holidayId, $isActive = true)
    {
        $result = BseHolidayModel::findOrFail($holidayId)
            ->update(['is_active' => $isActive]);

        self::invalidateCache();

        return $result;
    }

    /**
     * Delete a holiday
     *
     * @param int $holidayId
     * @return bool
     */
    public static function deleteHoliday($holidayId)
    {
        $result = BseHolidayModel::findOrFail($holidayId)->delete();

        self::invalidateCache();

        return $result;
    }

    /**
     * Invalidate the cache
     *
     * @return void
     */
    public static function invalidateCache()
    {
        Cache::forget(self::CACHE_KEY);
    }

    /**
     * Check if a date is a trading day (not weekend and not holiday)
     *
     * @param Carbon $date
     * @return bool
     */
    public static function isTradingDay(Carbon $date): bool
    {
        return !self::isWeekend($date) && !self::isBseHoliday($date);
    }

    /**
     * Get next trading day from given date
     *
     * @param Carbon $date
     * @return Carbon
     */
    public static function getNextTradingDay(Carbon $date): Carbon
    {
        $nextDay = $date->copy()->addDay();

        while (!self::isTradingDay($nextDay)) {
            $nextDay->addDay();
        }

        return $nextDay;
    }

    /**
     * Add trading days to a date
     * T+1 means 1 trading day (not calendar day)
     *
     * @param Carbon $date
     * @param int $tradingDays
     * @return Carbon
     */
    public static function addTradingDays(Carbon $date, int $tradingDays = 1): Carbon
    {
        $currentDate = $date->copy();

        for ($i = 0; $i < $tradingDays; $i++) {
            $currentDate = self::getNextTradingDay($currentDate);
        }

        return $currentDate;
    }

    /**
     * Get all BSE holidays (for backward compatibility and admin listing)
     *
     * @return array
     */
    public static function getHolidays(): array
    {
        return self::getActiveHolidayDates();
    }

    public static function isMarketTiming(): bool
    {
        $now = Carbon::now();

        $marketOpen  = CommonHelper::appSettings('peripo_market_open')  ?? '10:00';
        $marketClose = CommonHelper::appSettings('peripo_market_close') ?? '17:30';

        $openTime  = Carbon::createFromFormat('H:i', $marketOpen);
        $closeTime = Carbon::createFromFormat('H:i', $marketClose);

        return $now->between($openTime, $closeTime);
    }
}
