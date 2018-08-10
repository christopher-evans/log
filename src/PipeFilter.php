<?php
/**
 * This file is part of the West\\Log package
 *
 * (c) Chris Evans <cmevans@tutanota.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace West\Log;

/**
 * @brief Filter that passes for all times and log levels.
 *
 * @details A null object for the filter interface.
 *
 * @author Christopher Evans <cmevans@tutanota.com>
 * @see Filter
 * @date 8 October 2017
 */
final class PipeFilter implements Filter
{
    /**
     * PipeFilter constructor.
     */
    public function __construct()
    {
    }

    /**
     * @see Filter::filter
     */
    public function filter(string $level, \DateTimeInterface $time): bool
    {
        return true;
    }
}
