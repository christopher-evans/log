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
 * @brief %Notification sent out by an {@link AggregateLog}.
 *
 * @details <p>
 *     A notification is used to collect additional logic around a log Target, for example a Filter,
 *     Format or an Expansion.
 * </p>
 *
 * @author Christopher Evans <cmevans@tutanota.com>
 * @date 8 October 2017
 */
interface Notification
{
    /**
     * @brief Emit a message for a given time, level and message with context parameters.
     *
     * @param string             $level   Log severity level.
     * @param string             $message Log message.
     * @param array              $context Variables to be interpolated as defined in the
     *                                      PSR-3 specification.
     * @param \DateTimeInterface $time    Time stamp of the log entry.
     *
     * @return string Formatted log entry
     *
     * @throws \Exception If there was an error sending the notification.
     */
    public function send(string $level, string $message, array $context, \DateTimeInterface $time);
}
