<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Administration\DomainModel;

use Example\Domain\Common\Exception\InvalidArgumentException;

final class RecipeName
{
    /**
     * @var string
     */
    private $name;

    /**
     * @param string $name
     * @throws \Example\Domain\Common\Exception\InvalidArgumentException
     */
    private function __construct($name)
    {
        if (empty($name)) {
            throw new InvalidArgumentException('The recipe name cannot be empty.');
        }

        $this->name = $name;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return RecipeName
     */
    public static function fromString($name)
    {
        return new self($name);
    }
}
