<?php

namespace App\Services;

use App\Helpers\BseCalendarHelper;
use App\Helpers\CommonHelper;
use Carbon\Carbon;

/**
 * PreIpoBusinessDayService
 *
 * Holiday-aware business day helpers for Pre-IPO transaction timers.
 * Uses BseCalendarHelper for BSE holiday and weekend detection.
 *
 * Market hours: 10:00 AM – 5:30 PM, Monday–Friday, non-BSE-holiday days.
 */
class PreIpoBusinessDayService
{
    /**
     * Market open / close times (24h format).
     */
    // private const MARKET_OPEN_HOUR   = 10;
    // private const MARKET_OPEN_MIN    = 0;
    // private const MARKET_CLOSE_HOUR  = 17;
    // private const MARKET_CLOSE_MIN   = 30;

    /**
     * Check whether a given datetime falls within working hours
     * (Mon–Fri, 10:00–17:30, not a BSE holiday).
     */

    private function getMarketTimings(): array
    {
        return [
            'open'  => CommonHelper::appSettings('peripo_market_open'),  // 10:00
            'close' => CommonHelper::appSettings('peripo_market_close'), // 17:30
        ];
    }

    /**
     * Convert time string (HH:MM) into today's Carbon datetime
     */

    private function getTodayMarketTime(string $time, ?Carbon $date = null): Carbon
    {
        $date = $date ?? Carbon::today();

        return $date->copy()->setTimeFromTimeString($time);
    }

    public function isWorkingHours(Carbon $time): bool
    {
        if ($time->isWeekend()) {
            return false;
        }

        if (BseCalendarHelper::isBseHoliday($time)) {
            return false;
        }

        $open  = $this->getTodayMarketTime($this->getMarketTimings()['open'], $time);
        $close = $this->getTodayMarketTime($this->getMarketTimings()['close'], $time);

        return $time->between($open, $close);
    }

    /**
     * Return the start of the next working day (10:00 AM on a non-holiday weekday).
     * If the given date is itself a working day and before market close, returns today's open.
     */
    public function nextWorkingDayStart(Carbon $from): Carbon
    {
        $day = $from->copy()->addDay()->startOfDay();

        while ($day->isWeekend() || BseCalendarHelper::isBseHoliday($day)) {
            $day->addDay();
        }

        return $this->getTodayMarketTime($this->getMarketTimings()['open'], $day);
    }

    /**
     * Add N business days to a Carbon datetime.
     * Returns the deadline as the given datetime + 24 real hours per business day,
     * skipping weekends and BSE holidays.
     *
     * "1 business day" means: the next working calendar day + its full 24 real-clock hours.
     */
    public function addBusinessDay(Carbon $from, int $days = 1): Carbon
    {
        $current = $from->copy();

        for ($i = 0; $i < $days; $i++) {
            // Jump to start of the next business day
            $current = $this->nextWorkingDayStart($current);
        }

        // Timer is set 24 real-clock hours from the start of that business day
        return $current->addHours(24);
    }

    public function getNextActiveHours(int $hours = 2): string
    {
        // $now = Carbon::parse('2026-02-27 17:00:00');
        $now = Carbon::now();
        $timings = $this->getMarketTimings();

        $todayOpen  = $this->getTodayMarketTime($timings['open'], $now);
        $todayClose = $this->getTodayMarketTime($timings['close'], $now);

        // 30 minutes before closing = cutoff time
        $cutoffTime = $todayClose->copy()->subMinutes(30);

        // If NOT a trading day
        if (!BseCalendarHelper::isTradingDay($now)) {
            $start = $this->nextWorkingDayStart($now);
            return $start->copy()->addHours($hours)->toDateTimeString();
        }

        // Before market opens
        if ($now->lt($todayOpen)) {
            return $todayOpen->copy()->addHours($hours)->toDateTimeString();
        }

        // After cutoff time (last 30 minutes rule)
        if ($now->gte($cutoffTime)) {
            $start = $this->nextWorkingDayStart($now);
            return $start->copy()->addHours($hours)->toDateTimeString();
        }

        // During valid working hours
        return $now->copy()->addHours($hours)->toDateTimeString();
    }
}
