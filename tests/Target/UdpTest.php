<?php

namespace West\Log\Target;

use Psr\Log\LogLevel;
use West\Log\DefaultLogFormat;
use West\Log\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use DateTime;
use West\Log\UdpServer;

class UdpTest extends TestCase
{
    /** @var $logFormat DefaultLogFormat Log format */
    private $logFormat;

    /** @var $logTime int Log time */
    private $logTime;

    public function setUp()
    {
        $this->logFormat = new DefaultLogFormat(DateTime::ISO8601, PHP_EOL);
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

        new Udp('0.0.0.0', $port, $this->logFormat);
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

        new Udp($ipAddress, 40, $this->logFormat);
    }

    public function providerTestInvalidIp()
    {
        return [
            ['invalid-ip']
        ];
    }

    /**
     * @param string $ipAddress IP address
     *
     * @dataProvider providerTestValidPortIp
    public function testValidPortIp($ipAddress, $port)
    {
        //Reduce errors
        error_reporting(~E_WARNING);

        //Create a UDP socket
        if(!($sock = socket_create(AF_INET, SOCK_DGRAM, 0)))
        {
            $errorcode = socket_last_error();
            $errormsg = socket_strerror($errorcode);

            die("Couldn't create socket: [$errorcode] $errormsg \n");
        }

        echo "Socket created \n";

        // Bind the source address
        if( !socket_bind($sock, "127.0.0.1" , 9999) )
        {
            $errorcode = socket_last_error();
            $errormsg = socket_strerror($errorcode);

            die("Could not bind socket : [$errorcode] $errormsg \n");
        }

        echo "Socket bind OK \n";

        $udp = new Udp($ipAddress, $port, $this->logFormat);
        $udp->log(time(), 'error', 'Message', []);


        $r = socket_recvfrom($sock, $buf, 512, 0, $remote_ip, $remote_port);
        echo "$remote_ip : $remote_port -- " . $buf;
        socket_close($sock);
        exit;

        //Do some communication, this loop can handle multiple clients
        while(1)
        {
            echo "Waiting for data ... \n";

            //Receive some data
            $r = socket_recvfrom($sock, $buf, 512, 0, $remote_ip, $remote_port);
            echo "$remote_ip : $remote_port -- " . $buf;

            //Send back the data to the client
            socket_sendto($sock, "OK " . $buf , 100 , 0 , $remote_ip , $remote_port);
        }

        socket_close($sock);
        exit;
    }
     */

    /**
     * @param string $ipAddress IP address
     * @param int $port Port
     *
     * @dataProvider providerTestValidPortIp
     */
    public function testValidPortIp($ipAddress, $port)
    {
        // log data
        $logLevel = LogLevel::ALERT;
        $logMessage = 'Message {context}';
        $context = [
            'context' => 'context'
        ];

        // udp server
        $udpServer = new UdpServer($ipAddress, $port);
        $udpServer->open();

        // log
        $udp = new Udp($ipAddress, $port, $this->logFormat);
        $udp->log($this->logTime, $logLevel, $logMessage, $context);

        // read data
        $logValue = $udpServer->read(49);

        // compare
        $expectedLogValue = $this->logFormat->format($this->logTime, $logLevel, $logMessage, $context);
        $this->assertEquals($expectedLogValue, $logValue);
    }

    public function providerTestValidPortIp()
    {
        return [
            ['127.0.0.1', 1024]
        ];
    }
}
