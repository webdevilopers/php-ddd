<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Sale\DomainModel;

final class CustomerName
{
    /**
     * @param string $string
     *
     * @return CustomerName
     */
    public static function fromString($string)
    {
        return new self();
    }
}
