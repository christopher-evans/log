<?php

namespace West\Log;

use PHPUnit\Framework\TestCase;
use Psr\Log\LogLevel;
use West\Log\Exception\InvalidArgumentException;

class MinLevelFilterTest extends TestCase
{
    /**
     * @param string $filterLevel String to be sluggified
     * @param string $logLevel What we expect our slug result to be
     *
     * @dataProvider providerTestLevelFails
     */
    public function testLevelFails($filterLevel, $logLevel)
    {
        $filter = new MinLevelFilter($filterLevel);
        $time = time();

        $this->assertFalse($filter->filter($logLevel, $time));
    }

    public function providerTestLevelFails()
    {
        return [
            [LogLevel::WARNING, LogLevel::DEBUG],
            [LogLevel::WARNING, LogLevel::INFO],
            [LogLevel::WARNING, LogLevel::NOTICE]
        ];
    }

    /**
     * @param string $filterLevel String to be sluggified
     * @param string $logLevel What we expect our slug result to be
     *
     * @dataProvider providerTestLevelPasses
     */
    public function testLevelPasses($filterLevel, $logLevel)
    {
        $filter = new MinLevelFilter($filterLevel);
        $time = time();

        $this->assertTrue($filter->filter($logLevel, $time));
    }

    public function providerTestLevelPasses()
    {
        return [
            [LogLevel::WARNING, LogLevel::WARNING],
            [LogLevel::WARNING, LogLevel::ERROR],
            [LogLevel::WARNING, LogLevel::CRITICAL],
            [LogLevel::WARNING, LogLevel::ALERT],
            [LogLevel::WARNING, LogLevel::EMERGENCY]
        ];
    }

    public function testLevelException()
    {
        $this->expectException(InvalidArgumentException::class);

        $filter = new MinLevelFilter(LogLevel::WARNING);
        $time = time();
        $filter->filter('not-a-real-error-level', $time);
    }

    public function testConstructException()
    {
        $this->expectException(InvalidArgumentException::class);

        new MinLevelFilter('not-a-real-error-level');
    }
}
