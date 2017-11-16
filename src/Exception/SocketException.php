<?php
/*
 * This file is part of the West\\Log package
 *
 * (c) Chris Evans <cmevans@tutanota.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace West\Log\Exception;

/**
 * @brief Socket exception for West::Log namespace
 *
 * @details Grabs the last error message and code via <code>socket_last_error</code> and
 * <code>socket_strerror</code>.
 *
 * @author Christopher Evans <cmevans@tutanota.com>
 * @see http://php.net/manual/en/class.invalidargumentexception.php \InvalidArgumentException
 * @date 16 July 2017
 */
final class SocketException extends \RuntimeException
{
    public function __construct(string $message = '', \Throwable $previous = null)
    {
        $socketErrorCode = socket_last_error();
        $socketErrorMessage = socket_strerror($socketErrorCode);
        $errorMessage = $message . ' : ' . $socketErrorMessage;

        parent::__construct($errorMessage, $socketErrorCode, $previous);
    }
}
