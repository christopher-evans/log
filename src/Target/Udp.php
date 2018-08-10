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

use West\Log\Exception\InvalidArgumentException;
use West\Log\Exception\SocketException;

/**
 * @brief %Log target that sends data to a UDP socket.
 *
 * @TODO move socket_create outside this class
 * @details
 * <p>
 * For example:
 * <pre>
 *     <code>
 *         $ipAddress = '127.0.0.1';
 *         $port = 40;
 *
 *         $udpTarget = new UdpTarget($ipAddress, $port);
 *     </code>
 * </pre>
 * </p>
 *
 * @author Christopher Evans <cmevans@tutanota.com>
 * @see AbstractTarget
 * @date 17 March 2017
 */
final class Udp implements Target
{
    /**
     * @var resource $socket
     *
     * @brief UDP socket.
     */
    private $socket;

    /**
     * @var string $ipAddress
     *
     * @brief UDP server IP address.
     */
    private $ipAddress;

    /**
     * @var int $port
     *
     * @brief UDP server port.
     */
    private $port;

    /**
     * File constructor.
     *
     * @param string $ipAddress IP Address.
     * @param int    $port      Port.
     *
     * @throws InvalidArgumentException If the IP address or port is invalid.
     * @throws SocketException If the socket cannot be created.
     */
    public function __construct(string $ipAddress, int $port)
    {
        // validate IP address
        if (! filter_var($ipAddress, FILTER_VALIDATE_IP)) {
            throw new InvalidArgumentException(sprintf('Invalid IP address: %s', $ipAddress));
        }

        // validate port
        if ($port < 0 || ($port > 1 << 16)) {
            throw new InvalidArgumentException(sprintf('Invalid port: %s', $port));
        }

        // create socket
        $socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
        if ($socket === false) {
            throw new SocketException('Unable to create socket');
        }

        $this->ipAddress = $ipAddress;
        $this->port = $port;
        $this->socket = $socket;
    }

    /**
     * @see Target::emit
     */
    public function emit(string $message)
    {
        $bytes = socket_sendto(
            $this->socket,
            $message,
            mb_strlen($message),
            MSG_EOR,
            $this->ipAddress,
            $this->port
        );

        if ($bytes === false) {
            throw new SocketException('Error writing to socket');
        }
    }
}
