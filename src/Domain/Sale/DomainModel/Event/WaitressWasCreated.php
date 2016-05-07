<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Sale\DomainModel\Event;

use Example\Domain\Common\DomainModel\Event\DomainEvent;
use Example\Domain\Common\DomainModel\FullName;
use Example\Domain\Sale\DomainModel\Identity\EmployeeId;

final class WaitressWasCreated implements DomainEvent
{
    /**
     * @var EmployeeId
     */
    private $employeeId;

    /**
     * @var FullName
     */
    private $name;

    /**
     * @param EmployeeId $employeeId
     * @param FullName $name
     */
    public function __construct(EmployeeId $employeeId, FullName $name)
    {
        $this->employeeId = $employeeId;
        $this->name = $name;
    }

    /**
     * @return EmployeeId
     */
    public function employeeId()
    {
        return $this->employeeId;
    }

    /**
     * @return FullName
     */
    public function name()
    {
        return $this->name;
    }
}
