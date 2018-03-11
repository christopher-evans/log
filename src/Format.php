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
 * @brief Format a log entry from the time of the entry, log level and message.
 *
 * @details <p>
 * For example, the returned string could be in the format
 * <code>"[2017-01-01T00:00:00.000+0000] log-level : message"</code>
 * </p>
 *
 * @author Christopher Evans <cmevans@tutanota.com>
 * @date 17 March 2017
 */
interface Format
{
    /**
     * Format a log entry.
     *
     * @param \DateTimeInterface $time Time stamp for the log entry
     * @param string $level %Log severity level
     * @param string $message Log message. This message has been interpolated by an {@link Expansion}.
     *
     * @return string Formatted log entry
     */
    public function format(string $level, string $message, \DateTimeInterface $time): string;
}
