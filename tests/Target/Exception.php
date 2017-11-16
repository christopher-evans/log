<?php
/*
 * This file is part of the West\\Log package
 *
 * (c) Chris Evans <cmevans@tutanota.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace West\Log\Target;

/**
 * @brief %Log target that always throws an exception.
 *
 * @details Used for testing.
 *
 * @author Christopher Evans <cmevans@tutanota.com>
 * @see Target
 * @date 16 November 2017
 */
final class Exception implements Target
{
    /**
     * @see Target::emit
     */
    public function emit(string $message)
    {
        throw new \Exception('error', 0);
    }
}
