<?php

namespace West\Log\Target;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use org\bovigo\vfs\vfsStreamFile;
use West\Log\Exception\InvalidArgumentException;
use West\Log\Target\File as FileTarget;
use PHPUnit\Framework\TestCase;

class FileTest extends TestCase
{
    /** @var $root vfsStreamDirectory Root directory */
    private $root;

    /** @var $root vfsStreamFile Log file */
    private $logFile;

    public function setUp()
    {
        $this->root = vfsStream::setup('test-directory');
        $this->logFile = vfsStream::newFile('test-directory/test.log');
    }

    public function testLogFileIsCreated()
    {
        new FileTarget($this->logFile->url());

        $this->assertTrue($this->root->hasChild('test.log'));
    }

    public function testLogFileCantTouch()
    {
        $this->expectException(InvalidArgumentException::class);

        error_reporting(error_reporting() & ~E_USER_WARNING);
        $this->root->chmod(0444);
        error_reporting(error_reporting() & E_USER_WARNING);

        new FileTarget($this->logFile->url());
    }

    public function testLogFileNotWritable()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->logFile
            ->at($this->root)
            ->chmod(0555);

        new FileTarget($this->logFile->url());
    }

    public function testLogFileWritten()
    {
        $message = 'message';

        $fileTarget = new FileTarget($this->logFile->url());

        $fileTarget->emit($message);

        $writtenLogValue = file_get_contents($this->logFile->url());

        $this->assertEquals($message, $writtenLogValue);
    }
}
