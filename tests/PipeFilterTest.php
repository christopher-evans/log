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

class PipeFilterTest extends TestCase
{
    /**
     * @dataProvider providerTestPasses
     */
    public function testPasses($level, $time)
    {
        $filter = new PipeFilter();

        $this->assertTrue($filter->filter($level, $time));
    }

    public function providerTestPasses()
    {
        return [
            [
                '{}',
                new \DateTime()
            ],
            [
                'error',
                new \DateTime()
            ],
            [
                'debug',
                new \DateTimeImmutable()
            ],
        ];
    }
}
