<?php

/*
 * This file is part of Eloquent Models.
 *
 * (c) DraperStudio <hello@draperstudio.tech>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DraperStudio\Eloquent\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class ScopesTrait.
 *
 * @author DraperStudio <hello@draperstudio.tech>
 */
trait ScopesTrait
{
    /**
     * @param Builder $builder
     * @param $field
     * @param $value
     *
     * @return $this
     */
    public function scopeWhereLike(Builder $builder, $field, $value)
    {
        return $builder->where($field, 'like', "%$value%");
    }

    /**
     * @param Builder $builder
     * @param $field
     * @param $value
     *
     * @return Builder|static
     */
    public function scopeOrWhereLike(Builder $builder, $field, $value)
    {
        return $builder->orWhere($field, 'like', "%$value%");
    }

    /**
     * @param Builder $builder
     * @param $field
     * @param $value
     *
     * @return $this
     */
    public function scopeWhereIlike(Builder $builder, $field, $value)
    {
        return $builder->where($field, 'ilike', "%$value%");
    }

    /**
     * @param Builder $builder
     * @param $field
     * @param $value
     *
     * @return Builder|static
     */
    public function scopeOrWhereIlike(Builder $builder, $field, $value)
    {
        return $builder->orWhere($field, 'ilike', "%$value%");
    }
}
