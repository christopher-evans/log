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
 * @brief %Log format confirming to the PSR-3 specification.
 *
 * @details %Class for formatting structured log
 * data as a string. Meets the requirements are placed
 * on the formatting by the PSR-3 specification.
 *
 * @author Christopher Evans <c.m.evans@gmx.co.uk>
 * @see LogFormatInterface
 * @see http://www.php-fig.org/psr/psr-3/
 * @date 18 March 2017
 */
final class DefaultLogFormat implements LogFormatInterface
{
    /**
     * @brief Date format
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
     * @var string $contextStringRegex Regex used to validate context keys
     */
    private static $contextStringRegex = '/[^a-z0-9_\.]/i';

    /**
     * @brief DefaultLogFormat constructor.
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
     * @see LogFormatInterface::format
     */
    public function format(int $time, string $level, string $message, array $context = []): string
    {
        return '[' . date($this->dateFormat, $time) . '] ' . $level . ' ' .
            $this->interpolateMessage($message, $context) . $this->lineSeparator;
    }

    /**
     * @brief Replaces placeholders in the log message with values
     * from the context array.
     *
     * @param string $message %Log message
     * @param array $context %Context variables
     *
     * @return string Interpolated message
     */
    private function interpolateMessage(string $message, array $context = []): string
    {
        // build a replacement array with braces around the context keys
        $replace = [];
        foreach ($context as $key => $val) {
            // check the key is valid
            if (preg_match(self::$contextStringRegex, $key)) {
                throw new InvalidArgumentException('Context must contain only alphanumeric characters, \'_\' and \'.\'');
            }

            // check that the value can be casted to string
            if (is_string($val) || (is_object($val) && method_exists($val, '__toString'))) {
                $replace['{' . $key . '}'] = $val;
            }
        }

        // interpolate replacement values into the message and return
        return strtr($message, $replace);
    }
}
