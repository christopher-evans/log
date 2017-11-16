<?php

namespace West\Log;

use PHPUnit\Framework\TestCase;
use West\Log\Exception\InvalidArgumentException;

class MinLevelFilterTest extends TestCase
{
    /** @var $logLevels array Log levels */
    private $logLevels;

    /** @var $this->time \DateTimeInterface Log time */
    private $time;

    public function setUp()
    {
        $this->logLevels = [
            'debug' => 0,
            'info' => 1,
            'notice' => 2,
            'warning' => 3,
            'error' => 4,
            'critical' => 5,
            'alert' => 6,
            'emergency' => 7
        ];
        
        $this->time = new \DateTime();
    }

    /**
     * @param string $filterLevel String to be sluggified
     * @param string $logLevel What we expect our slug result to be
     *
     * @dataProvider providerTestLevelFails
     */
    public function testLevelFails($filterLevel, $logLevel)
    {
        $filter = new MinLevelFilter($this->logLevels, $filterLevel);

        $this->assertFalse($filter->filter($logLevel, $this->time));
    }

    public function providerTestLevelFails()
    {
        return [
            ['warning', 'debug'],
            ['warning', 'info'],
            ['warning', 'notice']
        ];
    }

    /**
     * @param string $filterLevel Filter minimum level
     * @param string $logLevel %log level
     *
     * @dataProvider providerTestLevelPasses
     */
    public function testLevelPasses($filterLevel, $logLevel)
    {
        $filter = new MinLevelFilter($this->logLevels, $filterLevel);

        $this->assertTrue($filter->filter($logLevel, $this->time));
    }

    public function providerTestLevelPasses()
    {
        return [
            ['warning', 'warning'],
            ['warning', 'error'],
            ['warning', 'critical'],
            ['warning', 'alert'],
            ['warning', 'emergency']
        ];
    }

    public function testLevelException()
    {
        $this->expectException(InvalidArgumentException::class);

        $filter = new MinLevelFilter($this->logLevels, 'warning');

        $filter->filter('not-a-real-error-level', $this->time);
    }

    public function testConstructException()
    {
        $this->expectException(InvalidArgumentException::class);

        new MinLevelFilter($this->logLevels, 'not-a-real-error-level');
    }
}
