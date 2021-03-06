<?php
/**
 * This file is part of the West\\Log package
 *
 * (c) Chris Evans <cmevans@tutanota.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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


    /**
     * @dataProvider providerTestInvalidContext
     */
    public function testInvalidContext($startDelimiter, $endDelimiter, $message, $context)
    {
        $this->expectException(InvalidArgumentException::class);

        $expansion = new StringExpansion($startDelimiter, $endDelimiter);

        $expansion->expand($message, $context);
    }

    public function providerTestInvalidContext()
    {
        return [
            [
                '{',
                '}',
                'message {key}',
                [
                    'key' => [
                        'array' => 'value-is-disallowed'
                    ]
                ]
            ],
            [
                '{',
                '}',
                'message {key}',
                [
                    'key' => [
                        'integer' => 'value-is-disallowed'
                    ]
                ]
            ]
        ];
    }
}
