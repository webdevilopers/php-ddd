<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Common\DomainModel;

final class MealName
{
    public static function fromString($name)
    {
        return new self();
    }
}
