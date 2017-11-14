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
 * @brief Format a log entry from the time of the entry, log level and message. Output is similar to some server logs.
 *
 * @details
 * <p>
 * A typical example would be:
 * <code>'[2017-01-01T00:00:00.000+0000] log-level message'</code>
 * </p>
 *
 * @author Christopher Evans <cmevans@tutanota.com>
 * @see Format
 * @see http://www.php-fig.org/psr/psr-3/
 * @date 18 March 2017
 */
final class ServerFormat implements Format
{
    /**
     * @brief Separator between log entries.
     * @details Passed to the PHP `date` function
     * @var string $dateFormat
     */
    private $dateFormat;

    /**
     * @brief Line separator
     * @details PHP_EOL is a sensible value
     * @var string $lineSeparator
     */
    private $lineSeparator;

    /**
     * @brief ServerFormat constructor.
     *
     * @details Construct a {@link ServerFormat} from a {@link DateFormat} and a line separator string.
     *
     * @param string $dateFormat Date format
     * @param string $lineSeparator Line separator
     */
    public function __construct(string $dateFormat, string $lineSeparator)
    {
        $this->dateFormat = $dateFormat;
        $this->lineSeparator = $lineSeparator;
    }

    /**
     * @see Format::format
     */
    public function format(string $level, string $message, \DateTimeInterface $time): string
    {
        return '[' . $time->format($this->dateFormat) . '] ' . $level . ' ' .
            $message . $this->lineSeparator;
    }
}
