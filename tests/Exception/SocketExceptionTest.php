<?php

namespace West\Log;

use PHPUnit\Framework\TestCase;
use West\Log\Exception\SocketException;

class SocketExceptionTest extends TestCase
{
    public function testMessage()
    {
        // clear socket error
        socket_clear_error();

        $exception = new SocketException('User message');

        $this->assertEquals($exception->getMessage(), 'User message : ' . socket_strerror(socket_last_error()));
    }
}
