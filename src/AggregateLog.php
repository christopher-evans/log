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
 * @brief %Log sending messages to an array of {Notification}s. %Log times default to the current time.
 *
 * @details
 * <p>
 *     A DefaultNotification comprises a {@link Target}, {@link Filter}, {@link Format} and {@link Expansion}.
 * </p>
 *
 * @author Christopher Evans <cmevans@tutanota.com>
 * @see West::Log::Log
 * @date 13 November 2017
 */
final class AggregateLog implements Log
{
    /**
     * @var iterable $notifications
     *
     * @brief %Log targets
     */
    private $notifications;

    /**
     * Log constructor.
     *
     * @param iterable $notifications An iterable class or array of notifications.
     *
     * @see Notification
     * @throws Exception\InvalidArgumentException If an entry is not a notification.
     */
    public function __construct(iterable $notifications)
    {
        foreach ($notifications as $notification) {
            if (! $notification instanceof Notification) {
                throw new Exception\InvalidArgumentException('Invalid notification.  Must implement Notification.');
            }
        }

        $this->notifications = $notifications;
    }

    /**
     * @brief Add a log entry with a time, level, message and context parameters.
     *
     * @param string             $level   Log level.
     * @param string             $message Log message.
     * @param array              $context Context parameters.
     * @param \DateTimeInterface $time    Log time.
     *
     * @throws Exception\AggregateException If there was an error adding the entry to one of the targets.
     */
    public function log(string $level, string $message, array $context = [], \DateTimeInterface $time = null)
    {
        if (null === $time) {
            $time = new \DateTimeImmutable();
        }

        $exceptions = new Exception\AggregateException('Error writing to log target.');
        foreach ($this->notifications as $notification) {
            /** @var Notification $notification */
            try {
                $notification->send($level, $message, $context, $time);
            } catch (\Exception $exception) {
                $exceptions->addException($exception);
            }
        }

        if ($exceptions->count()) {
            throw $exceptions;
        }
    }
}
