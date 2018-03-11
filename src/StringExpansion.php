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
 * @brief %Class for formatting structured log data as a string.
 *
 * @details %Expansion of parameters within a string using <code>__toString()</code>. This class meets the requirements
 * placed on formatting by the PSR-3 specification.
 *
 * <p>
 *     For example, if <code>$startDelimiter</code> and <code>$endDelimiter</code> are <code>'{'</code> and
 *     <code>'}'</code> respectively, then <code>'my {parameter}'</code> with context parameter <code>'parameter'</code>
 *     equal to any {@link Object} <code>$obj</code> implementing <code>__toString()</code> will evaluate to
 *     <code>'my ' . ((string) $obj)</code>.
 * </p>
 *
 * @author Christopher Evans <cmevans@tutanota.com>
 * @see Expansion
 * @date 18 March 2017
 */
final class StringExpansion implements Expansion
{
    /**
     * @brief Message parameter start delimiter
     * @details E.g. '{'
     * @var string $lineSeparator
     */
    private $startDelimiter;

    /**
     * @brief Message parameter end delimiter
     * @details E.g. '}'
     * @var string $lineSeparator
     */
    private $endDelimiter;

    /**
     * @brief Constructs a string expansion from a start and end delimiter wrapping each parameter.
     *
     * @param string $startDelimiter Message parameter start delimiter
     * @param string $endDelimiter Message parameter end delimiter
     *
     * @throws West::Log::Exception::InvalidArgumentException
     */
    public function __construct(string $startDelimiter, string $endDelimiter)
    {
        if (mb_strlen($startDelimiter) < 1 || mb_strlen($endDelimiter) < 1) {
            throw new Exception\InvalidArgumentException("Empty delimiter not allowed");
        }

        $this->startDelimiter = $startDelimiter;
        $this->endDelimiter = $endDelimiter;
    }

    /**
     * @see Expansion::expand
     */
    public function expand(string $message, array $context): string
    {
        if (count($context) < 1) {
            // escape early
            return $message;
        }

        // build a replacement array with braces around the context keys
        $replace = [];
        foreach ($context as $key => $val) {
            // check that the value can be cast to string
            if (! is_string($val) && (! is_object($val) || ! method_exists($val, '__toString'))) {
                throw new Exception\InvalidArgumentException(
                    sprintf('Invalid value for %s; must be a string or an object implementing __toString', $key)
                );
            }

            $replace['{' . $key . '}'] = $val;
        }

        // interpolate replacement values into the message and return
        return strtr($message, $replace);
    }
}
