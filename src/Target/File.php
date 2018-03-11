<?php
/*
 * This file is part of the West\\Log package
 *
 * (c) Chris Evans <cmevans@tutanota.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace West\Log\Target;

use West\Log\Exception\InvalidArgumentException;

/**
 * @brief %Log target that writes data to a file.
 *
 * @details The class will attempt to create the
 * file in the constructor if it does not exist.
 *
 * @author Christopher Evans <cmevans@tutanota.com>
 * @see AbstractTarget
 * @date 17 March 2017
 */
final class File implements Target
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
     *
     * @throws InvalidArgumentException
     */
    public function __construct(string $file)
    {
        if (! file_exists($file) && ! touch($file)) {
            throw new InvalidArgumentException(sprintf('File "%s" cannot be created', $file));
        }

        if (! is_writable($file)) {
            throw new InvalidArgumentException(sprintf('File "%s" is not writable', $file));
        }

        $this->file = $file;
    }

    /**
     * @see Target::emit
     */
    public function emit(string $message)
    {
        if (file_put_contents($this->file, $message, FILE_APPEND) === false) {
            throw new \Exception('Error writing to file');
        }
    }
}
