<?php

/*
 * This file is part of Eloquent Models.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

/*
 * This file is part of Eloquent Models.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BrianFaust\Eloquent\Models\Utils;

use Carbon\Carbon;

class DateTime
{
    /**
     * @param $ago
     * @param null $endDateTime
     *
     * @return array
     */
    public static function getDaysAgo($ago, $endDateTime = null)
    {
        return static::getDateTimeRange(
            Carbon::now()->subDays($ago)->startOfDay(),
            $endDateTime ?: Carbon::now()->subDays($ago)->endOfDay()
        );
    }

    /**
     * @param $ago
     * @param null $endDateTime
     *
     * @return array
     */
    public static function getWeeksAgo($ago, $endDateTime = null)
    {
        return static::getDateTimeRange(
            Carbon::now()->subWeeks($ago)->startOfWeek(),
            $endDateTime ?: Carbon::now()->subWeeks($ago)->endOfWeek()
        );
    }

    /**
     * @param $ago
     * @param null $endDateTime
     *
     * @return array
     */
    public static function getMonthsAgo($ago, $endDateTime = null)
    {
        return static::getDateTimeRange(
            Carbon::now()->subMonths($ago)->startOfMonth(),
            $endDateTime ?: Carbon::now()->subMonths($ago)->endOfMonth()
        );
    }

    /**
     * @param $ago
     * @param null $endDateTime
     *
     * @return array
     */
    public static function getYearsAgo($ago, $endDateTime = null)
    {
        return static::getDateTimeRange(
            Carbon::now()->subYears($ago)->startOfYear(),
            $endDateTime ?: Carbon::now()->subYears($ago)->endOfYear()
        );
    }

    /**
     * @param $ago
     * @param null $endDateTime
     *
     * @return array
     */
    public static function getDecadesAgo($ago, $endDateTime = null)
    {
        return static::getDateTimeRange(
            Carbon::now()->subYears($ago * 10)->startOfDecade(),
            $endDateTime ?: Carbon::now()->subYears($ago * 10)->endOfDecade()
        );
    }

    /**
     * @param $ago
     * @param null $endDateTime
     *
     * @return array
     */
    public static function getCenturiesAgo($ago, $endDateTime = null)
    {
        return static::getDateTimeRange(
            Carbon::now()->subYears($ago * 100)->startOfCentury(),
            $endDateTime ?: Carbon::now()->subYears($ago * 100)->endOfCentury()
        );
    }

    /**
     * @param $start
     * @param null $end
     * @param bool $exact
     *
     * @return array
     */
    public static function getDateTimeRange($start, $end = null, $exact = false)
    {
        return [
            static::buildDateTime($start, !$exact),
            static::buildDateTime($end ?: $start, false, !$exact),
        ];
    }

    /**
     * @param $dateTime
     * @param bool $startOfDay
     * @param bool $endOfDay
     *
     * @return string
     */
    private static function buildDateTime($dateTime, $startOfDay = false, $endOfDay = false)
    {
        $dateTime = new Carbon($dateTime);

        if ($startOfDay) {
            $dateTime = $dateTime->startOfDay();
        }

        if ($endOfDay) {
            $dateTime = $dateTime->endOfDay();
        }

        return (string) $dateTime;
    }
}
