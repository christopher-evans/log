<?php
/*
 * This file is part of the West\\Log package
 *
 * (c) Chris Evans <cmevans@tutanota.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace West\Log;

/**
 * @brief Filter that passes only log levels above a certain severity.
 *
 * @details <p>
 * Severity is defined by an associative array mapping levels to integers.
 * </p>
 *
 * <p>
 * For example if the map defines: <code>['debug' => 0, 'error' => 1]</code> and the minimum level is
 * <code>'error'</code> then only <code>'debug'</code> log entries will fail the filter.
 * </p>
 *
 * @author Christopher Evans <cmevans@tutanota.com>
 * @see Filter
 * @date 13 November 2017
 */
final class MinLevelFilter implements Filter
{
    /**
     * @brief Minimum severity that passes the filter
     *
     * @var int $minLevelOrder
     */
    private $minLevelOrder;

    /**
     * @brief Map from log levels to severity
     *
     * @var array $levelOrder
     */
    private $levelOrder;

    /**
     * MinLevelFilter constructor.
     *
     * @param array $levelOrder Map from log levels to severity
     * @param string $minLevel Minimum log level that will pass the filter
     */
    public function __construct(array $levelOrder, string $minLevel)
    {
        $this->levelOrder = $levelOrder;
        $this->minLevelOrder = $this->getLevelOrder($minLevel);
    }

    /**
     * @see Filter::filter
     */
    public function filter(string $level, \DateTimeInterface $time): bool
    {
        $levelOrder = $this->getLevelOrder($level);

        return $levelOrder >= $this->minLevelOrder;
    }

    /**
     * @brief Map a log level to an integer indicating severity.
     *
     * @param string $level %Log level
     *
     * @return int Severity of log level
     *
     * @throws West::Log::Exception::InvalidArgumentException
     */
    private function getLevelOrder(string $level)
    {
        if (! array_key_exists($level, $this->levelOrder)) {
            throw new Exception\InvalidArgumentException(sprintf('Invalid log level %s', $level));
        }

        return $this->levelOrder[$level];
    }
}
