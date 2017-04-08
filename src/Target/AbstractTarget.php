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

use West\Log\FilterInterface;
use West\Log\LogFormatInterface;

/**
 * @brief Abstract class implementing TargetInterface.
 *
 * @details This abstract class handles the log level
 * filtering and message formatting.
 * Child classes need only implement the `logString`
 * method that adds a string message to the target.
 *
 * @author Christopher Evans <c.m.evans@gmx.co.uk>
 *
 * @see TargetInterface
 *
 * @date 17 March 2017
 */
abstract class AbstractTarget implements TargetInterface
{
    /**
     * @brief Log level filter for this target.
     *
     * @var $filter FilterInterface
     */
    private $filter;

    /**
     * @brief %Log entry format for this target.
     *
     * @var $logFormat LogFormatInterface
     */
    private $logFormat;

    /**
     * @brief AbstractTarget constructor.
     *
     * @param LogFormatInterface $logFormat
     * @param FilterInterface|null $filter
     */
    public function __construct(LogFormatInterface $logFormat, FilterInterface $filter = null)
    {
        $this->filter = $filter;
        $this->logFormat = $logFormat;
    }

    /**
     * @see TargetInterface::log
     */
    public function log(int $time, string $level, string $message, array $context)
    {
        if (null === $this->filter || $this->filter->filter($level, $time)) {
            $this->logString($this->logFormat->format($time, $level, $message, $context));
        }
    }

    /**
     * @brief Adds a string formatted log entry to the target.
     *
     * @param string $message Log message
     */
    abstract protected function logString(string $message);
}
