<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Common\Exception;

use Example\Domain\Common\DomainModel\Identity\Identity;

final class EntityNotFoundException extends \Exception
{
    /**
     * @param Identity $identity
     *
     * @return EntityNotFoundException
     */
    public static function entityWithIdentity(Identity $identity)
    {
        return new self(
            "The entity of type '{$identity->getEntityClass()}' with identity '{$identity->id()}' could not be found."
        );
    }

    /**
     * @param string $class
     * @param string|object $value
     *
     * @return EntityNotFoundException
     */
    public static function entityWithValue($class, $value)
    {
        return new self(
            "The entity of type '{$class}' with value '{$value}' could not be found."
        );
    }
}
