<?php

namespace West\Log;

use PHPUnit\Framework\TestCase;
use Psr\Log\LogLevel;
use West\Log\Exception\InvalidArgumentException;
use DateTime;

class DefaultLogFormatTest extends TestCase
{
    public function testInvalidInterpolationKey()
    {
        $this->expectException(InvalidArgumentException::class);

        $logFormat = new ServerFormat(DateTime::ISO8601, PHP_EOL);

        $time = time();

        $logFormat->format(
            $time,
            LogLevel::NOTICE,
            'Message with {abc?}',
            [
                'abc?' => 'Value'
            ]
        );
    }

    public function testInterpolation()
    {
        $logFormat = new ServerFormat(DateTime::ISO8601, PHP_EOL);

        $time = time();

        $formattedValue = $logFormat->format(
            $time,
            LogLevel::NOTICE,
            'Message with {context}',
            [
                'context' => 'context'
            ]
        );

        $expectedResult = sprintf(
            '[%s] %s %s',
            date(DateTime::ISO8601, $time),
            LogLevel::NOTICE,
            'Message with context'
        ) . PHP_EOL;

        $this->assertEquals($formattedValue, $expectedResult);
    }


    public function testNoInterpolation()
    {
        $logFormat = new ServerFormat(DateTime::ISO8601, PHP_EOL);

        $time = time();

        $formattedValue = $logFormat->format($time, LogLevel::NOTICE, 'Message with no context');

        $expectedResult = sprintf(
            '[%s] %s %s',
            date(DateTime::ISO8601, $time),
            LogLevel::NOTICE,
            'Message with no context'
        ) . PHP_EOL;

        $this->assertEquals($formattedValue, $expectedResult);
    }
}
