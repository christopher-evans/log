<?php
/**
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
    /**
     * @var array $exceptions
     */
    private $exceptions = [];

    /**
     * Get an iterator over the aggregated exceptions.
     *
     * @return \Iterator The iterator.
     * @see \IteratorAggregate
     */
    public function getIterator(): \Iterator
    {
        return new \ArrayIterator($this->exceptions);
    }

    /**
     * Add an exception to the aggregate.
     *
     * @param \Exception $exception Exception.
     */
    public function addException(\Exception $exception)
    {
        $this->exceptions[] = $exception;
    }

    /**
     * Get the total number of exceptions.
     *
     * @return int
     * @see \Iterator
     */
    public function count()
    {
        return count($this->exceptions);
    }
}
