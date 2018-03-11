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
 * @brief %Expansion of parameters within a string.
 *
 * @details
 * <p>
 *     In a trivial example, <code>'hello {world}'</code> with context parameter <code>'world'</code> equal to
 *     <code>'WORLD'</code> might evaluate to <code>'hello WORLD'</code>.
 * </p>
 *
 * @author Christopher Evans <cmevans@tutanota.com>
 * @date 13 November 2017
 */
interface Expansion
{
    /**
     * @brief Expand a string containing parameter tokens (defined by the user in an implementation) using context
     * parameters.
     *
     * @param string $message %Log message optionally containing tokens
     * @param array  $context Context parameters (or token values)
     *
     * @return string Expanded message
     */
    public function expand(string $message, array $context): string;
}
