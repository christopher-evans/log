<?php
/**
 * This file is part of the West\\Log package
 *
 * (c) Chris Evans <cmevans@tutanota.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace West\Log\Target;

/**
 * @brief %Log target that discards the message with no action.
 *
 * @details Used for testing.
 *
 * @author Christopher Evans <cmevans@tutanota.com>
 * @see Target
 * @date 15 November 2017
 */
final class Sink implements Target
{
    /**
     * @see Target::emit
     */
    public function emit(string $message)
    {
        // do nothing
    }
}
