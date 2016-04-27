<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Common\Exception;

final class InvalidArgumentException extends \Exception
{
    /**
     * @param string $title
     *
     * @return InvalidArgumentException
     */
    public static function invalidJobTitle($title)
    {
        return new self("The job title '{$title}' is not supported.");
    }
}
