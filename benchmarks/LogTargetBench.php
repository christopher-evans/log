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
    /** @var $logMessage string Log message */
    private $logMessage;

    /** @var $fileTarget File File target */
    private $fileTarget;

    /** @var $udpTarget Udp UDP target */
    private $udpTarget;

    public function setUp()
    {
        $this->logMessage = 'Log message';

        $this->fileTarget = new File(sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'bench.log');
        $this->udpTarget = new Udp('127.0.0.1', 40);
    }

    public function benchFileTarget()
    {
        $this->fileTarget->emit($this->logMessage);
    }

    public function benchUdpTarget()
    {
        $this->udpTarget->emit($this->logMessage);
    }
}
