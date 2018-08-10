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
 * @brief %Filter to restrict logging for a log Target based on time or log level.
 *
 * @details
 * <p>
 * For example, a target might send an email only between 8am and 5pm for critical log entries.
 * </p>
 *
 * @author Christopher Evans <cmevans@tutanota.com>
 * @date 13 November 2017
 */
interface Filter
{
    /**
     * @brief Determine if a level should be logged.
     *
     * @param string             $level Log level.
     * @param \DateTimeInterface $time  Time stamp of the log entry.
     *
     * @return bool Return true if the level should be logged.
     */
    public function filter(string $level, \DateTimeInterface $time): bool;
}
