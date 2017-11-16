<?php

namespace West\Log;

use PHPUnit\Framework\TestCase;
use West\Log\Exception\AggregateException;
use West\Log\Exception\SocketException;

class AggregateExceptionTest extends TestCase
{
    /**
     * @dataProvider providerTestCount
     */
    public function testCount()
    {
        // clear socket error
        socket_clear_error();

        $exception = new AggregateException();
        foreach (func_get_args() as $ex) {
            $exception->addException($ex);
        }

        $this->assertEquals(count(func_get_args()), $exception->count());
    }

    public function providerTestCount()
    {
        return [
            [],
            [
                new \Exception()
            ],
            [
                new \Exception(),
                new \Exception(),
                new \Exception()
            ]
        ];
    }

    /**
     * @dataProvider providerTestIterator
     */
    public function testIterator()
    {
        // clear socket error
        socket_clear_error();

        $exception = new AggregateException();
        foreach (func_get_args() as $ex) {
            $exception->addException($ex);
        }

        $iterator = $exception->getIterator();
        foreach ($iterator as $index => $ex) {
            $this->assertEquals(func_get_arg($index), $ex);
        }
    }

    public function providerTestIterator()
    {
        return [
            [
                new \Exception()
            ],
            [
                new \Exception(),
                new \Exception(),
                new \Exception()
            ]
        ];
    }
}
