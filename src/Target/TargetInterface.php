<?php
/*
 * This file is part of the West\\Log package
 *
 * (c) Chris Evans <c.m.evans@gmx.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace West\Log\Target;

/**
 * @brief Interface for log target.
 *
 * @details Describes the log method a log
 * target must implement to be attached to
 * a Log instance.
 *
 * @author Christopher Evans <c.m.evans@gmx.co.uk>
 * @date 17 March 2017
 */
interface TargetInterface
{
    /**
     * Logs with an arbitrary level.
     *
     * @param int $time Unix time stamp for the log entry
     * @param string $level %Log level
     * @param string $message %Log message
     * @param array $context %Variables to be interpolated as defined in the
     * PSR-3 specification
     */
    public function log(int $time, string $level, string $message, array $context);
}
