<?php
/*
 * This file is part of the West\\Log package
 *
 * (c) Chris Evans <c.m.evans@gmx.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace West\Log\Target;

use West\Log\Exception\InvalidArgumentException;
use West\Log\FilterInterface;
use West\Log\LogFormatInterface;

/**
 * @brief %Log target that sends data to a UDP server.
 *
 * @author Christopher Evans <c.m.evans@gmx.co.uk>
 * @see AbstractTarget
 * @date 17 March 2017
 */
final class Udp extends AbstractTarget
{
    /**
     * @brief UDP socket.
     *
     * @var resource $socket
     */
    private $socket;

    /**
     * @brief UDP server IP address.
     *
     * @var string $ipAddress
     */
    private $ipAddress;

    /**
     * @brief UDP server port.
     *
     * @var int $port
     */
    private $port;

    /**
     * File constructor.
     *
     * @param string $ipAddress IP Address
     * @param int $port Port
     * @param LogFormatInterface $logFormat %Log format
     * @param FilterInterface|null $filter %Log level filter
     *
     * @throws InvalidArgumentException
     */
    public function __construct(string $ipAddress, int $port, LogFormatInterface $logFormat, FilterInterface $filter = null)
    {
        parent::__construct($logFormat, $filter);

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
            $errorCode = socket_last_error();
            $errorMessage = socket_strerror($errorCode);

            throw new InvalidArgumentException(sprintf('Unable to create socket: %s', $errorMessage));
        }

        $this->ipAddress = $ipAddress;
        $this->port = $port;
        $this->socket = $socket;
    }

    /**
     * @see AbstractTarget::logString
     */
    protected function logString(string $message)
    {
        socket_sendto($this->socket, $message, mb_strlen($message), MSG_EOR, $this->ipAddress, $this->port);
    }
}
