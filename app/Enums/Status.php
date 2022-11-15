<?php

namespace App\Enums;

use Rexlabs\Enum\Enum;

/**
 * The Status enum.
 *
 * @method static self PENDING()
 * @method static self IN_PROGRESS()
 * @method static self READY()
 */
class Status extends Enum
{
    const PENDING = 1;
    const IN_PROGRESS = 2;
    const READY = 3;

    /**
     * Retrieve a map of enum keys and values.
     *
     * @return array
     */
    public static function map() : array
    {
        return [
            static::PENDING => 'Pending',
            static::IN_PROGRESS  => 'In Progress',
            static::READY => 'Ready',
        ];
    }
}
