<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Common\DomainModel;

final class Money
{
    /**
     * @param string $string
     *
     * @return Money
     */
    public static function fromString($string)
    {
        return new self();
    }
}
