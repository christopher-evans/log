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
 * @brief %Interface for container piping data to log targets.
 *
 * @details Similar to the PSR-3 logger interface.
 *
 * @author Christopher Evans <c.m.evans@gmx.co.uk>
 * @since 16 July 2017
 */
interface LogInterface
{
    /**
     * Logs with an arbitrary level.
     *
     * @param string $level
     * @param string $message
     * @param array $context
     * @param int $time
     */
    public function log($level, $message, array $context = [], $time = 0);
}
