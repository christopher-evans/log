<?php
/**
 * This file is part of the West\\Log package
 *
 * (c) Chris Evans <cmevans@tutanota.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace West\Log;

use PHPUnit\Framework\TestCase;

class DefaultNotificationTest extends TestCase
{
    /**
     * @dataProvider providerTestFilter
     */
    public function testMessage()
    {
        $level = 'notice';
        $message = 'message';
        $time = new \DateTime();

        // null filter
        $filter = new PipeFilter();

        // format and expansion
        $format = new MessageFormat($message);
        $expansion = new StringExpansion('{', '}');

        // write to a variable
        $target = new Target\Variable();

        // create the notification
        $notification = new DefaultNotification(
            $target,
            $expansion,
            $format,
            $filter
        );

        $notification->send($level, $message, [], $time);
        $logString = (string) $target;

        $this->assertEquals($message, $logString);
    }

    /**
     * @dataProvider providerTestFilter
     */
    public function testFilter($notification, $target, $level, $message, $context, $time)
    {
        $notification->send($level, $message, $context, $time);

        $this->assertEquals((string) $target, '');
    }

    public function providerTestFilter()
    {
        // log levels
        $logLevels = [
            'debug' => 0,
            'info' => 1,
            'notice' => 2,
            'warning' => 3,
            'error' => 4,
            'critical' => 5,
            'alert' => 6,
            'emergency' => 7
        ];

        // log filter -- entries less than 'warning' are ignored
        $filter = new MinLevelFilter($logLevels, 'warning');

        // log format
        $format = new ServerFormat(\DateTime::W3C, "\n");

        // delimiters containing string parameters
        $expansion = new StringExpansion('{', '}');

        // write to a variable
        $target = new Target\Variable();

        // create the notification
        $notification = new DefaultNotification(
            $target,
            $expansion,
            $format,
            $filter
        );

        return [
            [
                $notification,
                $target,
                'notice',
                'message',
                [],
                new \DateTime()
            ],
            [
                $notification,
                $target,
                'debug',
                'message',
                [],
                new \DateTime()
            ]
        ];
    }
}
