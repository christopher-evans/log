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
 * @brief Log of messages with a time, log level and potentially context parameters.
 *
 * @details
 * <p>For example:</p>
 *
 * <pre>
 *     <code>
 *         $log = ...
 *         $context = ...
 *
 *         $log->log('error', 'Database error');
 *         $log->log('error', 'Database error: {detail}', $context);
 *         $log->log('error', 'Database error', [], new \DateTime());
 *         $log->log('error', 'Database error: {detail}', $context, new Date());
 *     </code>
 * </pre>
 *
 * @author Christopher Evans <cmevans@tutanota.com>
 * @date 13 November 2017
 * @see AggregateLog
 */
interface Log
{
    /**
     * @brief Add a log entry with a time, level, message and context parameters.
     *
     * @param string $level Log level
     * @param string $message Log message
     * @param array $context Context parameters
     * @param \DateTimeInterface $time Log time
     *
     * @throws \Exception
     */
    public function log(string $level, string $message, array $context = [], \DateTimeInterface $time = null);
}
