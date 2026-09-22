<?php

namespace App\Helpers;

use Carbon\Carbon;

class SettlementDateHelper
{
    /**
     * Calculate settlement date with T+1 logic (1 trading day after transaction date)
     * Excludes weekends and BSE holidays
     *
     * @param Carbon $transactionDate
     * @param int $tradingDays (default 1 for T+1)
     * @return Carbon
     */
    public static function calculateSettlementDate(Carbon $transactionDate, int $tradingDays = 1): Carbon
    {
        return BseCalendarHelper::addTradingDays($transactionDate, $tradingDays);
    }

    /**
     * Calculate T+1 settlement date
     *
     * @param Carbon $transactionDate
     * @return Carbon
     */
    public static function getT1SettlementDate(Carbon $transactionDate): Carbon
    {
        return self::calculateSettlementDate($transactionDate, 1);
    }

    /**
     * Calculate T+2 settlement date
     *
     * @param Carbon $transactionDate
     * @return Carbon
     */
    public static function getT2SettlementDate(Carbon $transactionDate): Carbon
    {
        return self::calculateSettlementDate($transactionDate, 2);
    }

    /**
     * Get settlement date info with trading days
     *
     * @param Carbon $transactionDate
     * @param int $tradingDays
     * @return array
     */
    public static function getSettlementInfo(Carbon $transactionDate, int $tradingDays = 1): array
    {
        $settlementDate = self::calculateSettlementDate($transactionDate, $tradingDays);

        return [
            'transaction_date' => $transactionDate->format('Y-m-d'),
            'settlement_date' => $settlementDate->format('Y-m-d'),
            'trading_days' => $tradingDays,
            'calendar_days' => $settlementDate->diffInDays($transactionDate),
            'settlement_format' => 'T+' . $tradingDays,
        ];
    }
}
