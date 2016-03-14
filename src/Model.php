<?php

/*
 * This file is part of Eloquent Models.
 *
 * (c) DraperStudio <hello@draperstudio.tech>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DraperStudio\Eloquent\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Model.
 *
 * @author DraperStudio <hello@draperstudio.tech>
 */
abstract class Model extends Eloquent implements ScopesContract
{
    use Traits\ScopesTrait;

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];
}
