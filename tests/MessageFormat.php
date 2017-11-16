<?php
/*
 * This file is part of the West\\Log package
 *
 * (c) Chris Evans <cmevans@tutanota.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace West\Log;

/**
 * @brief %Log format that produces a reliable string for testing.
 *
 * @author Christopher Evans <cmevans@tutanota.com>
 * @see Target
 * @date 16 November 2017
 */
final class MessageFormat implements Format
{
    /** @var $result string Result string */
    private $result;

    /**
     * MessageFormat constructor.
     *
     * @param string $result
     */
    public function __construct(string $result)
    {
        $this->result = $result;
    }

    /**
     * @see Format::format
     */
    public function format(string $level, string $message, \DateTimeInterface $time): string
    {
        return $this->result;
    }
}
