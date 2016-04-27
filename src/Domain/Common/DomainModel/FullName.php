<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Common\DomainModel;

final class FullName
{
    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @param string $firstName
     * @param string $lastName
     */
    private function __construct($firstName, $lastName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function firstName()
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function lastName()
    {
        return $this->lastName;
    }

    /**
     * @param FullName $name
     *
     * @return bool
     */
    public function equal(FullName $name)
    {
        return $name->firstName === $this->firstName && $name->lastName === $this->lastName;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return '[FullName] ' . $this->firstName . ' ' . $this->lastName;
    }

    /**
     * @param string $firstName
     * @param string $lastName
     *
     * @return FullName
     */
    public static function fromString($firstName, $lastName)
    {
        return new self($firstName, $lastName);
    }

    /**
     * @param string $name
     *
     * @return FullName
     */
    public static function fromSingleString($name)
    {
        return new self('Mr/Miss', $name);
    }
}
