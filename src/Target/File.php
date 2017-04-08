<?php
/*
 * This file is part of the West\\Log package
 *
 * (c) Chris Evans <c.m.evans@gmx.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace West\Log\Target;

use West\Log\Exception\InvalidArgumentException;
use West\Log\FilterInterface;
use West\Log\LogFormatInterface;

/**
 * @brief %Log target that writes data to a file.
 *
 * @details The class will attempt to create the
 * file in the constructor if it does not exist.
 *
 * @author Christopher Evans <c.m.evans@gmx.co.uk>
 * @see AbstractTarget
 * @date 17 March 2017
 */
final class File extends AbstractTarget
{
    /**
     * @brief File path.
     *
     * @var string $file
     */
    private $file;

    /**
     * File constructor.
     *
     * @param string $file File path. Should be absolute.
     * @param LogFormatInterface $logFormat %Log format
     * @param FilterInterface|null $filter %Log level filter
     *
     * @throws InvalidArgumentException
     */
    public function __construct(string $file, LogFormatInterface $logFormat, FilterInterface $filter = null)
    {
        parent::__construct($logFormat, $filter);

        if (! file_exists($file) && ! touch($file)) {
            throw new InvalidArgumentException(sprintf('File "%s" cannot be created', $file));
        }

        if (! is_writable($file)) {
            throw new InvalidArgumentException(sprintf('File "%s" is not writable', $file));
        }

        $this->file = $file;
    }

    /**
     * @see AbstractTarget::logString
     */
    protected function logString(string $message)
    {
        file_put_contents($this->file, $message, FILE_APPEND);
    }
}
