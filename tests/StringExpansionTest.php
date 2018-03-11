<?php

namespace West\Log;

use PHPUnit\Framework\TestCase;
use West\Log\Exception\InvalidArgumentException;

class StringExpansionTest extends TestCase
{
    /**
     * @dataProvider providerTestExpansion
     */
    public function testExpansion($startDelimiter, $endDelimiter, $message, $context, $expectedResult)
    {
        $expansion = new StringExpansion($startDelimiter, $endDelimiter);

        $expandedValue = $expansion->expand($message, $context);

        $this->assertEquals($expandedValue, $expectedResult);
    }

    public function providerTestExpansion()
    {
        return [
            [
                '{',
                '}',
                'message',
                [],
                'message'
            ],
            [
                '{',
                '}',
                'hello {world}',
                [
                    'world' => 'WORLD'
                ],
                'hello WORLD'
            ],
            [
                '{',
                '}',
                'hello {world} hello {world}',
                [
                    'world' => 'WORLD'
                ],
                'hello WORLD hello WORLD'
            ],
            [
                '{',
                '}',
                '{object} {value}',
                [
                    'object' => new CastableObject('foo'),
                    'value' => new CastableObject('bar')
                ],
                'foo bar'
            ]
        ];
    }


    /**
     * @dataProvider providerTestInvalidDelimiter
     */
    public function testInvalidDelimiter($startDelimiter, $endDelimiter)
    {
        $this->expectException(InvalidArgumentException::class);

        new StringExpansion($startDelimiter, $endDelimiter);
    }

    public function providerTestInvalidDelimiter()
    {
        return [
            [
                '',
                '}'
            ],
            [
                '{',
                ''
            ],
            [
                '',
                ''
            ]
        ];
    }
}
