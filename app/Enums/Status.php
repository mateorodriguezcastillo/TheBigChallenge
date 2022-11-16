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
    const PENDING = "pending";
    const IN_PROGRESS = "in_progress";
    const READY = "ready";

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
