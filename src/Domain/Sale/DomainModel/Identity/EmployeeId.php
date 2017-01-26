<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Sale\DomainModel\Identity;

use Example\Domain\Common\DomainModel\FullName;
use Example\Domain\Common\DomainModel\Identity\Identity;
use Example\Domain\Sale\DomainModel\Employee;

final class EmployeeId implements Identity
{
    /**
     * @var mixed
     */
    private $id;

    /**
     * @param mixed $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getEntityClass()
    {
        return Employee::class;
    }

    /**
     * @return mixed
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @param FullName $name
     *
     * @return EmployeeId
     */
    public static function fromName(FullName $name)
    {
        return new self($name->toString());
    }

    /**
     * @param string $string
     *
     * @return EmployeeId
     */
    public static function fromString($string)
    {
        return new self($string);
    }
}
