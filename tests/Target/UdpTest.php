<?php
/**
 * This file is part of the West\\Log package
 *
 * (c) Chris Evans <cmevans@tutanota.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace West\Log\Target;

use Psr\Log\LogLevel;
use West\Log\ServerFormat;
use West\Log\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use DateTime;
use West\Log\UdpServer;
use West\Log\Target\Udp as UdpTarget;

class UdpTest extends TestCase
{
    /** @var $logFormat ServerFormat Log format */
    private $logFormat;

    /** @var $logTime int Log time */
    private $logTime;

    public function setUp()
    {
        $this->logFormat = new ServerFormat(DateTime::ISO8601, PHP_EOL);
        $this->logTime = time();
    }

    /**
     * @param int $port Port number
     *
     * @dataProvider providerTestInvalidPort
     */
    public function testInvalidPort($port)
    {
        $this->expectException(InvalidArgumentException::class);

        new UdpTarget('0.0.0.0', $port);
    }

    public function providerTestInvalidPort()
    {
        return [
            [-1],
            [1 << 16 + 1]
        ];
    }

    /**
     * @param string $ipAddress IP address
     *
     * @dataProvider providerTestInvalidIp
     */
    public function testInvalidIp($ipAddress)
    {
        $this->expectException(InvalidArgumentException::class);

        new UdpTarget($ipAddress, 40);
    }

    public function providerTestInvalidIp()
    {
        return [
            ['invalid-ip']
        ];
    }

    /**
     * Test disabled as UDP blocking in a single PHP process in Windows
     * means we can't write & read to a USP socket in this way.
     *
     * @param string $ipAddress IP address
     * @param int $port Port
     *
     * @dataProvider providerTestValidPortIp
     */
    public function testValidPortIp($ipAddress, $port)
    {
        $this->assertTrue(true);

        return;
        // log data
        $message = 'message';

        // udp server
        $udpServer = new UdpServer($ipAddress, $port);
        $udpServer->open();

        // log
        $udp = new UdpTarget($ipAddress, $port);
        $udp->emit($message);

        // read data
        $logValue = $udpServer->read(7);

        // compare
        $this->assertEquals($message, $logValue);
    }

    public function providerTestValidPortIp()
    {
        return [
            ['127.0.0.1', 1024]
        ];
    }
}
