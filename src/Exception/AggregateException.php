<?php
/*
 * This file is part of the West\\Log package
 *
 * (c) Chris Evans <cmevans@tutanota.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace West\Log\Exception;

/**
 * @brief Aggregate exception accumulates exceptions thrown when logging to multiple
 * targets.
 *
 * @details <p>
 *     This ensures an error logging to one target does not interrupt others, while the exception may still be caught
 *     once logging is complete.
 * </p>
 *
 * @author Christopher Evans <cmevans@tutanota.com>
 * @see http://php.net/manual/en/class.invalidargumentexception.php \InvalidArgumentException
 * @date 13 November 2017
 */
final class AggregateException extends \Exception implements \IteratorAggregate, \Countable
{
    private $exceptions = [];

    public function __construct($message = '', $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function getIterator(): \Iterator
    {
        return new \ArrayIterator($this->exceptions);
    }

    public function addException(\Exception $exception)
    {
        $this->exceptions[] = $exception;
    }

    public function count()
    {
        return count($this->exceptions);
    }
}
