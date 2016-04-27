<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Infrastructure\InMemory;

use Example\Domain\Common\DomainModel\JobTitle;
use Example\Domain\Common\Exception\EntityNotFoundException;
use Example\Domain\Sale\DomainModel\Employee;
use Example\Domain\Sale\DomainModel\EmployeeRepository;
use Example\Domain\Sale\DomainModel\Identity\EmployeeId;
use Example\Domain\Shipping\DomainModel\DeliveryBoy;
use Example\Domain\Shipping\DomainModel\DeliveryBoyRepository;

final class EmployeeCollection implements EmployeeRepository, DeliveryBoyRepository, \Countable
{
    /**
     * @var Employee[]
     */
    private $employees = [];

    /**
     * @param EmployeeId $id
     *
     * @return Employee
     * @throws EntityNotFoundException when not found
     */
    public function employeeWithIdentity(EmployeeId $id)
    {
        if (! isset($this->employees[$id->id()])) {
            throw EntityNotFoundException::entityWithIdentity($id);
        }

        return $this->employees[$id->id()];
    }

    /**
     * @param Employee $employee
     */
    public function saveEmployee(Employee $employee)
    {
        $this->employees[$employee->getIdentity()->id()] = $employee;
    }

    /**
     * @return int The custom count as an integer.
     */
    public function count()
    {
        return count($this->employees);
    }

    /**
     * @param JobTitle $title
     *
     * @throws \Example\Domain\Common\Exception\EntityNotFoundException
     * @return Employee[]
     */
    public function employeesWithTitle(JobTitle $title)
    {
        $employees = [];
        foreach ($this->employees as $employee) {
            if ($employee->matchTitle($title)) {
                $employees[] = $employee;
            }
        }

        return $employees;
    }

    /**
     * @param DeliveryBoy $deliveryBoy
     */
    public function saveDeliveryBoy(DeliveryBoy $deliveryBoy)
    {
        $this->employees[$deliveryBoy->getIdentity()->id()] = $deliveryBoy;
    }
}
