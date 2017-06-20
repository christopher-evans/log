<?php

namespace West\Log;

use West\Log\Exception\InvalidArgumentException;

class UdpServer
{
    /** @var $ipAddress string IP address */
    private $ipAddress;

    /** @var $port int Port */
    private $port;

    /** @var $socket resource UDP socket */
    private $socket;

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

        $this->ipAddress = $ipAddress;
        $this->port = $port;
    }

    public function open()
    {
        $socket = socket_create(AF_INET, SOCK_DGRAM, 0);
        if (! $socket) {
            $errorCode = socket_last_error();
            $errorMessage = socket_strerror($errorCode);

            throw new InvalidArgumentException(sprintf('Unable to create socket: %s', $errorMessage));
        }

        $bindSuccess = socket_bind($socket, $this->ipAddress, $this->port);
        if (! $bindSuccess) {
            $errorCode = socket_last_error();
            $errorMessage = socket_strerror($errorCode);

            throw new InvalidArgumentException(sprintf('Unable to bind socket: %s', $errorMessage));
        }

        $this->socket = $socket;
    }

    public function read(int $length)
    {
        if (! $this->socket) {
            throw new InvalidArgumentException('Socket is not bound to an address');
        }

        $bytes = socket_recvfrom($this->socket, $buffer, $length, 0, $remoteIp, $remotePort);
        if ($bytes === false) {
            $errorCode = socket_last_error();
            $errorMessage = socket_strerror($errorCode);

            throw new InvalidArgumentException(sprintf('Unable to read data: %s', $errorMessage));
        }

        var_dump($bytes);

        return $buffer;
    }

    public function close()
    {
        if (! $this->socket) {
            socket_close($this->socket);
        }
    }
}
