<?php

namespace West\Log;

use org\bovigo\vfs\vfsStreamDirectory;
use org\bovigo\vfs\vfsStreamFile;
use PHPUnit\Framework\TestCase;
use West\Log\Exception\InvalidArgumentException;
use org\bovigo\vfs\vfsStream;
use Psr\Log\LogLevel;
use DateTime;

class LogTest extends TestCase
{
    /** @var $root vfsStreamDirectory Root directory */
    private $root;

    /** @var $root vfsStreamFile Log file */
    private $logFile;

    /** @var $logFormat ServerFormat Log format */
    private $logFormat;

    /** @var $filter Filter Filter */
    private $filter;

    public function setUp()
    {
        $this->root = vfsStream::setup('test-directory');
        $this->logFile = vfsStream::newFile('test-directory/test.log');
        $this->logFormat = new ServerFormat(DateTime::ISO8601, PHP_EOL);
        $this->filter = new MinLevelFilter(LogLevel::WARNING);
    }

    public function testInvalidTarget()
    {
        $this->expectException(InvalidArgumentException::class);

        $targets = [
            new \stdClass()
        ];

        new AggregateLog($targets);
    }

    public function testLogFilter()
    {
        $targets = [
            new Target\File($this->logFile->url(), $this->logFormat, $this->filter)
        ];

        $log = new AggregateLog($targets);
        $log->log(
            LogLevel::NOTICE,
            'Here is a message with {context}',
            [
                'context' => 'context'
            ]
        );

        $expectedLogValue = '';
        $writtenLogValue = file_get_contents($this->logFile->url());

        $this->assertEquals($expectedLogValue, $writtenLogValue);
    }
}
