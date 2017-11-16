<?php

namespace West\Log;

use PHPUnit\Framework\TestCase;

class ServerFormatTest extends TestCase
{
    /**
     * @param string $filterLevel Filter minimum level
     * @param string $logLevel %log level
     *
     * @dataProvider providerTestFormat
     */
    public function testFormat($dateFormat, $lineSeparator, $level, $message, $time, $expectedResult)
    {
        $format = new ServerFormat($dateFormat, $lineSeparator);

        $formattedValue = $format->format($level, $message, $time);

        $this->assertEquals($formattedValue, $expectedResult);
    }

    public function providerTestFormat()
    {
        $time = new \DateTime('2000-01-01T00:00:00+00:00');

        return [
            [
                \DateTime::W3C,
                PHP_EOL,
                'error',
                'message',
                $time,
                sprintf(
                    '[%s] %s %s',
                    $time->format(\DateTime::W3C),
                    'error',
                    'message'
                ) . PHP_EOL
            ]
        ];
    }
}
