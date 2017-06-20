<?php
/*
 * This file is part of the West\\Uri package
 *
 * (c) Chris Evans <c.m.evans@gmx.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace West\Log;

use Psr\Log\LogLevel;
use West\Log\Target\File;
use West\Log\Target\Udp;

/**
 * @Revs({1, 8, 64, 4096})
 * @Iterations(10)
 * @Sleep(500000)
 * @BeforeMethods({"setUp"})
 */
class LogTargetBench
{
    /** @var $defaultLogFormat DefaultLogFormat Log format */
    private $defaultLogFormat;

    /** @var $logLevel string Log level */
    private $logLevel;

    /** @var $logMessage string Log message */
    private $logMessage;

    /** @var $context array Context array */
    private $context;

    /** @var $time int Time */
    private $time;

    /** @var $fileTarget File File target */
    private $fileTarget;

    /** @var $udpTarget Udp UDP target */
    private $udpTarget;

    public function setUp()
    {
        $this->defaultLogFormat = new DefaultLogFormat('Y-m-s H:i:s', PHP_EOL);
        $this->logLevel = LogLevel::ALERT;
        $this->logMessage = 'Log message';
        $this->context = [];
        $this->time = time();

        $this->fileTarget = new File(
            sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'bench.log',
            $this->defaultLogFormat
        );
        $this->udpTarget = new Udp('127.0.0.1', 40, $this->defaultLogFormat);
    }

    public function benchFileTarget()
    {
        $this->fileTarget->log($this->time, $this->logLevel, $this->logMessage, $this->context);
    }

    public function benchUdpTarget()
    {
        $this->udpTarget->log($this->time, $this->logLevel, $this->logMessage, $this->context);
    }
}
