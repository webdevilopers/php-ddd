<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Sale\DomainModel;

use Example\Domain\Common\DomainModel\JobTitle;
use Example\Domain\Common\Exception\EntityNotFoundException;
use Example\Domain\Sale\DomainModel\Identity\EmployeeId;

interface EmployeeRepository
{
    /**
     * @param EmployeeId $id
     *
     * @return Employee
     * @throws EntityNotFoundException when not found
     */
    public function employeeWithIdentity(EmployeeId $id);

    /**
     * @param Employee $employee
     */
    public function saveEmployee(Employee $employee);

    /**
     * @param JobTitle $title
     *
     * @return Employee[]
     */
    public function employeesWithTitle(JobTitle $title);
}
