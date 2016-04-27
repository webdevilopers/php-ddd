<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Infrastructure\InMemory;

use Example\Domain\Common\DomainModel\FullName;
use Example\Domain\Common\DomainModel\JobTitle;
use Example\Domain\Sale\DomainModel\Cashier;
use Example\Domain\Sale\DomainModel\Cook;
use Example\Domain\Sale\DomainModel\Employee;
use Example\Domain\Sale\DomainModel\Identity\EmployeeId;

final class EmployeeCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EmployeeCollection
     */
    private $collection;

    public function setUp()
    {
        $this->collection = new EmployeeCollection();
    }

    public function test_it_should_return_employee_with_id()
    {
        $employee = $this->createEmployee(new EmployeeId('fixture'), JobTitle::fromString('fake'));

        $this->assertCount(0, $this->collection);
        $this->collection->saveEmployee($employee);
        $this->assertCount(1, $this->collection);
        $this->assertSame($employee, $this->collection->employeeWithIdentity($employee->getIdentity()));
    }

    /**
     * @expectedException \Example\Domain\Common\Exception\EntityNotFoundException
     * @expectedExceptionMessage The entity of type 'Example\Domain\Sale\DomainModel\Employee' with identity '123' could not
     */
    public function test_it_should_throw_exception_when_not_found()
    {
        $this->assertCount(0, $this->collection);
        $this->collection->employeeWithIdentity(new EmployeeId(123));
    }

    public function test_it_should_return_the_employees_with_title()
    {
        $cook1 = new Cook(new EmployeeId('cook-1'), FullName::fromSingleString('cook1'));
        $cashier = new Cashier(new EmployeeId('cashier'), FullName::fromSingleString('cashier'));
        $cook2 = new Cook(new EmployeeId('cook-2'), FullName::fromSingleString('cook2'));;

        $this->collection->saveEmployee($cook1);
        $this->collection->saveEmployee($cashier);
        $this->collection->saveEmployee($cook2);

        $this->assertCount(3, $this->collection);
        $this->assertCount(1, $this->collection->employeesWithTitle(JobTitle::Cashier()));
        $this->assertCount(2, $this->collection->employeesWithTitle(JobTitle::Cook()));
        $this->assertCount(0, $this->collection->employeesWithTitle(JobTitle::Waitress()));
    }

    /**
     * @param EmployeeId $id
     * @param JobTitle $title
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|Employee
     */
    private function createEmployee(EmployeeId $id, JobTitle $title)
    {
        $mock = $this->getMock(Employee::class);
        $mock
            ->method('getIdentity')
            ->willReturn($id);

        return $mock;
    }
}
