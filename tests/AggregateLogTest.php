<?php

namespace West\Log;

use PHPUnit\Framework\TestCase;
use West\Log\Exception\AggregateException;
use West\Log\Exception\InvalidArgumentException;

class AggregateLogTest extends TestCase
{
    /** @var $format ServerFormat Log format */
    private $format;

    /** @var $message string Log message */
    private $message;

    /** @var $filter Filter Filter */
    private $filter;

    /** @var $expansion Expansion Expansion */
    private $expansion;

    public function setUp()
    {
        $this->message = 'message';
        $this->format = new MessageFormat($this->message);
        $this->filter = new PipeFilter();
        $this->expansion = new StringExpansion('{', '}');
    }

    public function testTargetException()
    {
        $this->expectException(Exception\AggregateException::class);

        $target = new Target\Exception();
        $notification = new DefaultNotification(
            $target,
            $this->expansion,
            $this->format,
            $this->filter
        );
        $log = new AggregateLog(
            [
                $notification
            ]
        );

        $log->log('notice', 'message');
    }

    public function testTargetExceptionDoesNotBlock()
    {
        $exceptionTarget = new Target\Exception();
        $variableTarget = new Target\Variable();

        $notifications = [
            new DefaultNotification(
                $exceptionTarget,
                $this->expansion,
                $this->format,
                $this->filter
            ),
            new DefaultNotification(
                $variableTarget,
                $this->expansion,
                $this->format,
                $this->filter
            ),
            new DefaultNotification(
                $exceptionTarget,
                $this->expansion,
                $this->format,
                $this->filter
            ),
        ];
        $log = new AggregateLog($notifications);

        try {
            $log->log('notice', 'any-message');
        } catch (AggregateException $exception) {
            // pass through
        }

        $this->assertEquals((string) $variableTarget, $this->message);
    }

    public function testLogSuccess()
    {
        $variableTarget = new Target\Variable();

        $log = new AggregateLog(
            [
                new DefaultNotification(
                    $variableTarget,
                    $this->expansion,
                    $this->format,
                    $this->filter
                )
            ]
        );

        $log->log('notice', 'any-message');

        $this->assertEquals((string) $variableTarget, $this->message);
    }

    /**
     * @dataProvider providerTestInvalidNotification
     */
    public function testInvalidNotification($notifications)
    {
        $this->expectException(InvalidArgumentException::class);

        new AggregateLog($notifications);
    }

    public function providerTestInvalidNotification()
    {
        return [
            [
                [
                    'string'
                ]
            ],
            [
                [
                    121
                ]
            ],
            [
                [
                    new \stdClass()
                ]
            ]
        ];
    }
}
