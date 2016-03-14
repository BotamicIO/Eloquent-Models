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

use DraperStudio\Eloquent\Uuid\UuidModel as UuidTrait;

/**
 * Class UuidModel.
 *
 * @author DraperStudio <hello@draperstudio.tech>
 */
abstract class UuidModel extends Model
{
    use UuidTrait;

    /**
     * @var bool
     */
    public $incrementing = false;
}
