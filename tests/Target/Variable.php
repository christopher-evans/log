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
 * @brief %Log target that writes to a known variable.
 *
 * @details Used for testing.
 *
 * @author Christopher Evans <cmevans@tutanota.com>
 * @see Target
 * @date 16 November 2017
 */
final class Variable implements Target
{
    private $message = '';

    /**
     * @see Target::emit
     */
    public function emit(string $message)
    {
        $this->message = $message;
    }

    public function __toString()
    {
        return $this->message;
    }
}
