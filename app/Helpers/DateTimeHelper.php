<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateTimeHelper
{
    static function viewDate($date): string
    {
        return $date != NULL ? Carbon::parse($date)->format('d M Y') : '';
    }

    static function getDBDateTime($datetime): string
    {
        return $datetime != NULL ? Carbon::parse($datetime)->format('Y-m-d H:i:s') : NULL;
    }

    static function formatDateTime($datetime, $format): string
    {
        return Carbon::parse($datetime)->format($format);
    }

    static function LastQuartersDates()
    {
        $quarters = [];

        // Get the current date
        $currentDate = Carbon::now();
        $currentDate;
        for ($i = 0; $i < 6; $i++) {
            // Calculate the start and end of the quarter based on your specified months
            $quarterStart = $currentDate->copy()->startOfQuarter();
            $quarterEnd = $currentDate->copy()->endOfQuarter();

            // Adjust the start and end to fit your desired format
            $quarters[] = [
                $quarterEnd->format('M Y'),
                $quarterStart->format('Y-m-d'),
                $quarterEnd->format('Y-m-d'),
            ];

            // Move to the previous quarter
            $currentDate->subMonths(3);
        }

        return array_reverse($quarters, false);
    }

    static function slashDateToDashDate($item)
    {
        return str_replace('/', '-', $item);
    }

    static function LastSixFinancialYears()
    {
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;
        $startYear = $currentMonth >= 4 ? $currentYear - 1 : $currentYear;

        $financialYears = [];
        for ($i = 0; $i < 6; $i++) {
            $endYear = $startYear;
            $startYear--;
            $financialYears[] = [
                'start' => Carbon::createFromDate($startYear, 4, 1)->toDateString(), // Financial year starts from April 1st
                'end' => Carbon::createFromDate($endYear, 3, 31)->toDateString(), // Financial year ends on March 31st
                'view'  => $startYear . '-' . $endYear
            ];
        }

        // Return or process $financialData as required
        return array_reverse($financialYears, false);
    }

    static function getLast6QuartersDates()
    {
        $quartersPeriods = [
            [
                'from' => '01-04-',
                'to' => '30-06-'
            ],
            [
                'from' => '01-07-',
                'to' => '30-09-'
            ],
            [
                'from' => '01-10-',
                'to' => '31-12-'
            ],
            [
                'from' => '01-01-',
                'to' => '31-03-'
            ]
        ];
        $quarters = [];

        // Get the current date
        $currentDate = Carbon::now();
        $currentDate;
        for ($i = 0; $i < 6; $i++) {
            // Calculate the start and end of the quarter based on your specified months
            $quarterStart = $currentDate->copy()->startOfQuarter();
            $quarterEnd = $currentDate->copy()->endOfQuarter();

            foreach ($quartersPeriods as $key => $value) {
                $from = Carbon::parse($value['from'] . $quarterStart->format('Y'));
                if ($quarterStart->isSameDay($from)) {
                    $quarters[] = [
                        'quater'    => 'Q' . ($key + 1) . '-' . $quarterStart->format('Y'),
                        'start'     => $quarterStart->format('Y-m-d'),
                        'end'       => $quarterEnd->format('Y-m-d'),
                    ];
                }
            }


            // Move to the previous quarter
            $currentDate->subMonths(3);
        }

        return array_reverse($quarters, false);
    }

    static function getLast6Months()
    {
        $months = [];
        $currentDate = Carbon::now()->startOfMonth();

        for ($i = 0; $i < 6; $i++) {
            $monthStart = $currentDate->copy()->startOfMonth()->format('Y-m-d');
            $monthEnd = $currentDate->copy()->endOfMonth()->format('Y-m-d');

            $months[] = [
                'month' => $currentDate->format('F Y'),
                'start' => $monthStart,
                'end'   => $monthEnd,
            ];

            $currentDate->subMonth();
        }

        return $months;
    }


    static function formatElapsedTime($date1, $now = null): string
    {
        $created = Carbon::parse($date1);
        $now     = $now ? Carbon::parse($now) : Carbon::now();

        // $minutes = abs($now->diffInMinutes($created));
        $minutes = (int) abs($now->diffInMinutes($created));
        if ($minutes < 60) {
            return $minutes . ' minutes';
        }

        $hours     = floor($minutes / 60);
        $remaining = $minutes % 60;

        if ($remaining === 0) {
            return $hours . ' hours';
        }

        return $hours . ' hours ' . $remaining . ' minutes';
    }
}
