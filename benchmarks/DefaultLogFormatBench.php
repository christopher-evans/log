<?php
/*
 * This file is part of the West\\Uri package
 *
 * (c) Chris Evans <cmevans@tutanota.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace West\Log;

/**
 * @Revs({1, 8, 64, 4096})
 * @Iterations(10)
 * @Sleep(500000)
 * @BeforeMethods({"setUp"})
 */
class DefaultLogFormatBench
{
    /** @var $defaultLogFormat ServerFormat Log format */
    private $defaultLogFormat;

    /** @var $logLevel string Log level */
    private $logLevel;

    /** @var $logMessage string Log message */
    private $logMessage;

    /** @var $context array Context array */
    private $context;

    /** @var $time \DateTimeInterface Time */
    private $time;

    public function setUp()
    {
        $this->defaultLogFormat = new ServerFormat('Y-m-s H:i:s', PHP_EOL);
        $this->logLevel = 'alert';
        $this->logMessage = 'Log message';
        $this->context = [
            'context' => 'Context'
        ];
        $this->time = new \DateTimeImmutable();
    }

    public function benchFormat()
    {
        $this->defaultLogFormat->format(
            $this->logLevel,
            $this->logMessage,
            $this->time
        );
    }
}
