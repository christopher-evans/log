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

/**
 * @brief %Log format interface.
 *
 * @details %Interface for formatting structured log
 * data as a string. Additional requirements are placed
 * on the formatting by the PSR-3 specification.
 *
 * @author Christopher Evans <c.m.evans@gmx.co.uk>
 * @see http://www.php-fig.org/psr/psr-3/
 * @date 17 March 2017
 */
interface LogFormatInterface
{
    /**
     * @param int $time Unix time stamp for the log entry
     * @param string $level %Log severity level
     * @param string $message %Log message
     * @param array $context %Variables to be interpolated as defined in the
     * PSR-3 specification
     *
     * @return string Formatted log entry
     */
    public function format(int $time, string $level, string $message, array $context = []): string;
}
