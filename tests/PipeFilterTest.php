<?php

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
