<?php

namespace App\Supports;

use Illuminate\Support\Carbon;

/**
 *
 */
trait DateConvertor
{
    /**
     * isoToUTCFormat => convert ISOString to UTC date format
     *
     ** 2019-10-09T18:30:00.000Z => 2019-10-09 18:30:00.0 UTC (+00:00)
     *
     * @param  mixed $date => ISO String Date Format
     *
     * @return void
     */
    protected function isoToUTCFormat($date)
    {
        $gameStart = Carbon::parse($date, 'UTC');
        $newDate = new Carbon($gameStart->toDateTimeString(), 'UTC');
        $newDate->timezone = env('APP_TIMEZONE');
        return $newDate;

        // $timestamp = '2014-02-06 16:34:00';
        // $date = Carbon::createFromFormat('Y-m-d H:i:s', $timestamp, 'Europe/Stockholm');
        // $date->setTimezone('UTC');
    }

    /**
     * getCurrentDateUTC => get Current date in UTC format
     *
     * @return void
     */
    protected function getCurrentDateUTC()
    {
        $date = \Carbon\Carbon::now();
        $date = $date->toDateTimeString();
        return $date;
    }

    protected function getCurrentMonthByGivenDate($date)
    {
        // $date = \Carbon\Carbon::now();
        $date = $date->toDateTimeString();
        return $date;
    }

    /**
     * subtractWeeksFromCurrentUTC => For Subtract week from current UTC date
     *
     * @param  mixed $numberOfWeeks
     *
     * @return void
     */
    protected function subtractWeeksFromCurrentUTC($numberOfWeeks = 0)
    {
        $currentDate = \Carbon\Carbon::now();
        $weekAgoDate = $currentDate->subWeeks($numberOfWeeks)->toDateTimeString();
        return $weekAgoDate;
    }

    protected function getCurrentStartOfTheDay()
    {
        $now = \Carbon\Carbon::now();
        $weekStartDate = $now->startOfDay()->toDateTimeString();
        return $weekStartDate;
    }

    protected function getCurrentEndOfTheDay()
    {
        $now = \Carbon\Carbon::now();
        $weekEndDate = $now->endOfDay()->toDateTimeString();
        return $weekEndDate;
    }

    protected function getDateWiseStartOfTheWeek($date)
    {
        $weekStartDate = $date->startOfWeek()->toDateTimeString();
        return $weekStartDate;
    }
    // getDateWiseEndOfTheWeek
    protected function getDateWiseEndOfTheWeek($date)
    {
        $weekEndDate = $date->endOfWeek()->toDateTimeString();
        return $weekEndDate;
    }

    protected function getCurrentStartOfTheWeek()
    {
        $now = \Carbon\Carbon::now();
        $weekStartDate = $now->startOfWeek()->toDateTimeString();
        return $weekStartDate;
    }

    protected function getCurrentEndOfTheWeek()
    {
        $now = \Carbon\Carbon::now();
        $weekEndDate = $now->endOfWeek()->toDateTimeString();
        return $weekEndDate;
    }

    protected function getDateWisePreviousStartOfTheWeek($date)
    {
        $previousWeekStartDate = $date->startOfWeek()->subWeek(1)->toDateTimeString();
        return $previousWeekStartDate;
    }
    protected function getDateWisePreviousEndOfTheWeek($date)
    {
        $previousWeekStartDate = $date->endOfWeek()->subWeek(1)->toDateTimeString();
        return $previousWeekStartDate;
    }

    protected function getPreviousStartOfTheWeek()
    {
        $now = \Carbon\Carbon::now();
        $previousWeekStartDate = $now->startOfWeek()->subWeek(1)->toDateTimeString();
        return $previousWeekStartDate;
    }
    protected function getPreviousEndOfTheWeek()
    {
        $now = \Carbon\Carbon::now();
        $previousWeekStartDate = $now->endOfWeek()->subWeek(1)->toDateTimeString();
        return $previousWeekStartDate;
    }

    public function getAllWeeksDatesFromDateRange($startDate, $endDate, $format = 'Y-m-d')
    {
        $dateRangeArray = \Carbon\CarbonPeriod::create($startDate, $endDate)->toArray();
        foreach ($dateRangeArray as $carbonObj) {
            $allDates[] = $carbonObj->format($format);
        }
        $allDates = array_chunk($allDates, 7);
        return $allDates;
    }
}
