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
 * @brief %Log target that writes data to a file.
 *
 * @details The class will attempt to create the
 * file in the constructor if it does not exist.
 *
 * @author Christopher Evans <cmevans@tutanota.com>
 * @see AbstractTarget
 * @date 17 March 2017
 */
final class Sink
{
    /**
     * @see Target::emit
     */
    protected function emit(string $message)
    {
        // do nothing
    }
}
