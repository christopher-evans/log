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

/**
 * @Revs({1, 8, 64, 4096})
 * @Iterations(10)
 * @BeforeMethods({"setUp"})
 */
class DefaultLogFormatBench
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

    public function setUp()
    {
        $this->defaultLogFormat = new DefaultLogFormat('Y-m-s H:i:s', PHP_EOL);
        $this->logLevel = LogLevel::ALERT;
        $this->logMessage = 'Log message';
        $this->context = [
            'context' => 'Context'
        ];
        $this->time = time();
    }

    public function benchFormat()
    {
        $this->defaultLogFormat->format(
            $this->time,
            $this->logLevel,
            $this->logMessage,
            $this->context
        );
    }
}
