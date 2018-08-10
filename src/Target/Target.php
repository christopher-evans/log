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
 * @brief Target medium (file, UDP server, ...) for a log entry.
 *
 * @details Sends a formatted log string to a log medium.
 *
 * @author Christopher Evans <cmevans@tutanota.com>
 * @date 17 March 2017
 * @see File
 * @see Udp
 */
interface Target
{
    /**
     * Send a formatted log entry.
     *
     * @param string $message Formatted log entry.
     *
     * @throws \Exception If there was an error sending the message to the target.
     */
    public function emit(string $message);
}
