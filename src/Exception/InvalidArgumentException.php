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

use Psr\Log\InvalidArgumentException as PsrInvalidArgumentException;

/**
 * @brief Invalid argument exception for West::Log namespace
 *
 * @details This class is to allow West::Log exceptions to be caught
 * and does not define any functionality beyond that of
 * Psr::Log::InvalidArgumentException.
 *
 * @author Christopher Evans <c.m.evans@gmx.co.uk>
 *
 * @see http://www.php-fig.org/psr/psr-3/ Psr::Log::InvalidArgumentException
 *
 * @date 18 March 2017
 */
class InvalidArgumentException extends PsrInvalidArgumentException
{

}
