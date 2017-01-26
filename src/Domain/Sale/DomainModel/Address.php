<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Sale\DomainModel;

final class Address
{
    /**
     * @param string $address
     *
     * @return Address
     */
    public static function fromString($address)
    {
        return new self();
    }
}
