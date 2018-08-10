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

/**
 * @brief Object with known __toString value for testing.
 *
 * @author Christopher Evans <cmevans@tutanota.com>
 * @date 15 November 2017
 */
final class CastableObject
{
    /** @var string $value String value */
    private $value;

    /**
     * CastableObject constructor.
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
