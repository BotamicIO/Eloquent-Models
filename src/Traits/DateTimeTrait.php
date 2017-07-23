<?php

/*
 * This file is part of Eloquent Models.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BrianFaust\Eloquent\Models\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use BrianFaust\Eloquent\Models\Utils\DateTime;

trait DateTimeTrait
{
    /**
     * @param Builder $query
     *
     * @return mixed
     */
    public function scopeFromToday(Builder $query)
    {
        return $this->fromThisDay();
    }

    /**
     * @param Builder $query
     *
     * @return mixed
     */
    public function scopeFromYesterday(Builder $query)
    {
        return $this->fromLastDay();
    }

    /**
     * @param Builder $query
     *
     * @return mixed
     */
    public function scopeFromLastSevenDays(Builder $query)
    {
        return $this->fromDaysAgo(6, Carbon::now()->endOfDay());
    }

    /**
     * @param Builder $query
     *
     * @return mixed
     */
    public function scopeFromLastThirtyDays(Builder $query)
    {
        return $this->fromDaysAgo(29, Carbon::now()->endOfDay());
    }

    /**
     * @param Builder $query
     *
     * @return mixed
     */
    public function scopeFromLastFourWeeks(Builder $query)
    {
        return $this->fromDaysAgo(Carbon::now()->daysInMonth, Carbon::now()->endOfDay());
    }

    /**
     * @param Builder $query
     *
     * @return mixed
     */
    public function scopeFromThisDay(Builder $query)
    {
        return $this->fromDaysAgo(0);
    }

    /**
     * @param Builder $query
     *
     * @return mixed
     */
    public function scopeFromThisWeek(Builder $query)
    {
        return $this->fromWeeksAgo(0);
    }

    /**
     * @param Builder $query
     *
     * @return mixed
     */
    public function scopeFromThisMonth(Builder $query)
    {
        return $this->fromMonthsAgo(0);
    }

    /**
     * @param Builder $query
     *
     * @return mixed
     */
    public function scopeFromThisYear(Builder $query)
    {
        return $this->fromYearsAgo(0);
    }

    /**
     * @param Builder $query
     *
     * @return mixed
     */
    public function scopeFromThisDecade(Builder $query)
    {
        return $this->fromDecadesAgo(0);
    }

    /**
     * @param Builder $query
     *
     * @return mixed
     */
    public function scopeFromThisCentury(Builder $query)
    {
        return $this->fromCenturiesAgo(0);
    }

    /**
     * @param Builder $query
     *
     * @return mixed
     */
    public function scopeFromLastDay(Builder $query)
    {
        return $this->fromDaysAgo(1);
    }

    /**
     * @param Builder $query
     *
     * @return mixed
     */
    public function scopeFromLastWeek(Builder $query)
    {
        return $this->fromWeeksAgo(1);
    }

    /**
     * @param Builder $query
     *
     * @return mixed
     */
    public function scopeFromLastMonth(Builder $query)
    {
        return $this->fromMonthsAgo(1);
    }

    /**
     * @param Builder $query
     *
     * @return mixed
     */
    public function scopeFromLastYear(Builder $query)
    {
        return $this->fromYearsAgo(1);
    }

    /**
     * @param Builder $query
     *
     * @return mixed
     */
    public function scopeFromLastDecade(Builder $query)
    {
        return $this->fromDecadesAgo(1);
    }

    /**
     * @param Builder $query
     *
     * @return mixed
     */
    public function scopeFromLastCentury(Builder $query)
    {
        return $this->fromCenturiesAgo(1);
    }

    /**
     * @param Builder $query
     * @param $ago
     * @param null $endDateTime
     *
     * @return mixed
     */
    public function scopeFromDaysAgo(Builder $query, $ago, $endDateTime = null)
    {
        return $this->scopeFromDateTimeRange(DateTime::getDaysAgo($ago, $endDateTime));
    }

    /**
     * @param Builder $query
     * @param $ago
     * @param null $endDateTime
     *
     * @return mixed
     */
    public function scopeFromWeeksAgo(Builder $query, $ago, $endDateTime = null)
    {
        return $this->scopeFromDateTimeRange(DateTime::getWeeksAgo($ago, $endDateTime));
    }

    /**
     * @param Builder $query
     * @param $ago
     * @param null $endDateTime
     *
     * @return mixed
     */
    public function scopeFromMonthsAgo(Builder $query, $ago, $endDateTime = null)
    {
        return $this->scopeFromDateTimeRange(DateTime::getMonthsAgo($ago, $endDateTime));
    }

    /**
     * @param Builder $query
     * @param $ago
     * @param null $endDateTime
     *
     * @return mixed
     */
    public function scopeFromYearsAgo(Builder $query, $ago, $endDateTime = null)
    {
        return $this->scopeFromDateTimeRange(DateTime::getYearsAgo($ago, $endDateTime));
    }

    /**
     * @param Builder $query
     * @param $ago
     * @param null $endDateTime
     *
     * @return mixed
     */
    public function scopeFromDecadesAgo(Builder $query, $ago, $endDateTime = null)
    {
        return $this->scopeFromDateTimeRange(DateTime::getDecadesAgo($ago, $endDateTime));
    }

    /**
     * @param Builder $query
     * @param $ago
     * @param null $endDateTime
     *
     * @return mixed
     */
    public function scopeFromCenturiesAgo(Builder $query, $ago, $endDateTime = null)
    {
        return $this->scopeFromDateTimeRange(DateTime::getCenturiesAgo($ago, $endDateTime));
    }

    /**
     * @param Builder $query
     * @param $range
     * @param bool $exact
     *
     * @return mixed
     */
    public function scopeFromDateTimeRange(Builder $query, $range, $exact = true)
    {
        if (! is_array($range)) {
            $range = DateTime::getDateTimeRange($range, $range, $exact);
        } else {
            $range = [
                (string) new Carbon($range[0]),
                (string) new Carbon($range[1]),
            ];
        }

        return $query->whereBetween('created_at', $range);
    }
}
