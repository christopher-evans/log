<?php
/*
 * This file is part of the West\\Log package
 *
 * (c) Chris Evans <c.m.evans@gmx.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace West\Log\Exception;

use InvalidArgumentException as RootInvalidArgumentException;

/**
 * @brief Invalid argument exception for West::Log namespace
 *
 * @details This class is to allow West::Log exceptions to be caught
 * and does not define any functionality beyond that of
 * Psr::Log::InvalidArgumentException.
 *
 * @author Christopher Evans <c.m.evans@gmx.co.uk>
 *
 * @see http://php.net/manual/en/class.invalidargumentexception.php \InvalidArgumentException
 *
 * @since 18 March 2017
 * @updated 16 July 2017
 */
class InvalidArgumentException extends RootInvalidArgumentException
{

}
