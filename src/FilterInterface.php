<?php
/*
 * This file is part of the West\\Log package
 *
 * (c) Chris Evans <c.m.evans@gmx.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace West\Log;

/**
 * @brief %Log level filter interface.
 *
 * @details %Interface for filtering log level severity
 * and time stamp to determine in an entry will be made.
 *
 * @author Christopher Evans <c.m.evans@gmx.co.uk>
 * @see http://www.php-fig.org/psr/psr-3/
 * @date 18 March 2017
 */
interface FilterInterface
{
    /**
     * @brief Determine if a level should be logged.
     *
     * @param string $level %Log level
     * @param int $time %Time stamp of the log entry
     *
     * @return bool Return true if the level should be logged.
     */
    public function filter(string $level, int $time): bool;
}
