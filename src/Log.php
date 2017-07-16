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

use West\Log\Exception\InvalidArgumentException;

/**
 * @brief %Log container piping data to multiple targets.
 *
 * @author Christopher Evans <c.m.evans@gmx.co.uk>
 * @see http://www.php-fig.org/psr/psr-3/
 * @date 17 March 2017
 */
final class Log implements LogInterface
{
    /**
     * @brief %Log targets
     *
     * @var array $logTargets
     */
    private $logTargets;

    /**
     * Log constructor.
     *
     * @param iterable $logTargets An iterable class or array of
     * objects implementing Target::TargetInterface
     *
     * @see Target::TargetInterface
     * @throws InvalidArgumentException
     */
    public function __construct(iterable $logTargets)
    {
        $this->logTargets = [];
        foreach ($logTargets as $logTarget) {
            if (!$logTarget instanceof Target\TargetInterface) {
                throw new InvalidArgumentException('Invalid log target.  Must implement TargetInterface');
            }

            $this->logTargets[] = $logTarget;
        }
    }

    /**
     * @see West::Log::LogInterface::log
     */
    public function log($level, $message, array $context = [], $time = 0)
    {
        if (0 === $time) {
            $time = time();
        }

        foreach ($this->logTargets as $logTarget) {
            $logTarget->log($time, $level, $message, $context);
        }
    }
}
