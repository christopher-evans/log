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

use Psr\Log\LogLevel;
use West\Log\Exception\InvalidArgumentException;

/**
 * @brief Filter that passes only log levels above a
 * certain severity.
 *
 * %Log level severity, in descending order is defined
 * to be:
 *
 * - 'emergency'
 * - 'alert'
 * - 'critical'
 * - 'error'
 * - 'warning'
 * - 'info'
 * - 'notice'
 * - 'debug'
 *
 * For example if
 * ```javascript
 * $filter = new \West\Log\MinLevelFilter('critical');
 * ```
 * then levels 'critical', 'alert' and 'emergency' will
 * pass.
 *
 * @author Christopher Evans <c.m.evans@gmx.co.uk>
 * @see FilterInterface
 * @date 17 March 2017
 */
final class MinLevelFilter implements FilterInterface
{
    /**
     * @brief Minimum log level that will pass the filter
     *
     * @var int $minLevelOrder
     */
    private $minLevelOrder;

    /**
     * MinLevelFilter constructor.
     *
     * @param string $minLevel Minimum log level that will pass the filter
     */
    public function __construct(string $minLevel)
    {
        $this->minLevelOrder = $this->getLevelOrder($minLevel);
    }

    /**
     * @see FilterInterface::filter
     */
    public function filter(string $level, int $time): bool
    {
        $levelOrder = $this->getLevelOrder($level);

        return $levelOrder >= $this->minLevelOrder;
    }

    /**
     * @brief Map a log level to an integer indicating severity.
     *
     * Defines an order on the set of log levels for comparison.
     *
     * @param string $level %Log level
     *
     * @return int Severity of log level
     *
     * @throws West::Log::Exception::InvalidArgumentException
     */
    private function getLevelOrder(string $level)
    {
        switch ($level) {
            case 'debug':
                return 0;
            case 'info':
                return 1;
            case 'notice':
                return 2;
            case 'warning':
                return 3;
            case 'error':
                return 4;
            case 'critical':
                return 5;
            case 'alert':
                return 6;
            case 'emergency':
                return 7;
        }

        throw new InvalidArgumentException(sprintf('Invalid log level %s', $level));
    }
}
