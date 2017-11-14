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
 * @brief Notification sent out by an AggregateLog.
 *
 * @details
 * A Notification aggregating a Target, Filter, Format and Expansion.
 *
 * <p>
 *     A filter is applied to potentially prevent message emission.  Then the message is expanded, and the log entry
 *     formatted.  The final string is then emitted by the target.
 * </p>
 *
 * @author Christopher Evans <cmevans@tutanota.com>
 * @see Notification
 * @date 13 November 2017
 */
final class DefaultNotification implements Notification
{
    /**
     * @brief %Log target
     * @see UdpTarget
     * @see OutputStreamTarget
     */
    private $target;

    /**
     * @brief Message expansion.
     * @see StringExpansion
     */
    private $expansion;

    /**
     * @brief %Log entry format.
     * @see ServerFormat
     */
    private $format;

    /**
     * @brief %Log entry filter.
     * @see LevelFilter
     * @see PipeFilter
     */
    private $filter;

    /**
     * @brief Construct a DefaultNotification from a target, expansion, format and filter.
     *
     * @param Target\Target $target Log target
     * @param Expansion $expansion Message expansion
     * @param Format $format Log entry format
     * @param Filter $filter Log entry filter
     */
    public function __construct(
        Target\Target $target,
        Expansion $expansion,
        Format $format,
        Filter $filter
    ) {
        $this->target = $target;
        $this->expansion = $expansion;
        $this->format = $format;
        $this->filter = $filter;
    }

    /**
     * @see Notification::send
     */
    public function send(string $level, string $message, array $context, \DateTimeInterface $time)
    {
        if (! $this->filter->filter($level, $time)) {
            return;
        }

        $this->target->emit(
            $this->format->format(
                $level,
                $this->expansion->expand($message, $context),
                $time
            )
        );
    }
}
