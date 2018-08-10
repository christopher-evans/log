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
 * @brief Invalid argument exception for West::Log namespace
 *
 * @details This class is to allow West::Log exceptions to be caught
 * and does not define any functionality beyond that of
 * \InvalidArgumentException.
 *
 * @author Christopher Evans <cmevans@tutanota.com>
 * @see http://php.net/manual/en/class.invalidargumentexception.php \InvalidArgumentException
 * @date 16 July 2017
 */
final class InvalidArgumentException extends \InvalidArgumentException
{

}
