<?php

namespace West\Log\Target;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use org\bovigo\vfs\vfsStreamFile;
use Psr\Log\LogLevel;
use West\Log\DefaultLogFormat;
use West\Log\Exception\InvalidArgumentException;
use West\Log\Target\File as FileTarget;
use PHPUnit\Framework\TestCase;
use DateTime;

class FileTest extends TestCase
{
    /** @var $root vfsStreamDirectory Root directory */
    private $root;

    /** @var $root vfsStreamFile Log file */
    private $logFile;

    /** @var $logFormat DefaultLogFormat Log format */
    private $logFormat;

    /** @var $logTime int Log time */
    private $logTime;

    public function setUp()
    {
        $this->root = vfsStream::setup('test-directory');
        $this->logFile = vfsStream::newFile('test-directory/test.log');
        $this->logFormat = new DefaultLogFormat(DateTime::ISO8601, PHP_EOL);
        $this->logTime = time();
    }

    public function testLogFileIsCreated()
    {
        new FileTarget($this->logFile->url(), $this->logFormat);

        $this->assertTrue($this->root->hasChild('test.log'));
    }

    public function testLogFileCantTouch()
    {
        $this->expectException(InvalidArgumentException::class);

        error_reporting(error_reporting() & ~E_USER_WARNING);
        $this->root->chmod(0444);
        error_reporting(error_reporting() & E_USER_WARNING);

        new FileTarget($this->logFile->url(), $this->logFormat);
    }

    public function testLogFileNotWritable()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->logFile
            ->at($this->root)
            ->chmod(0555);

        new FileTarget($this->logFile->url(), $this->logFormat);
    }

    public function testLogFileWritten()
    {
        $logFormat = $this->logFormat;

        $logFile = new FileTarget($this->logFile->url(), $logFormat);

        $logFile->log($this->logTime, LogLevel::NOTICE, 'message', []);

        $expectedLogValue = $logFormat->format($this->logTime, LogLevel::NOTICE, 'message');
        $writtenLogValue = file_get_contents($this->logFile->url());

        $this->assertEquals($expectedLogValue, $writtenLogValue);
    }
}