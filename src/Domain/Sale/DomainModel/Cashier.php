<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Sale\DomainModel;

use Example\Domain\Common\DomainModel\AggregateRoot;
use Example\Domain\Common\DomainModel\FullName;
use Example\Domain\Common\DomainModel\JobTitle;
use Example\Domain\Sale\DomainModel\Event\CashierWasCreated;
use Example\Domain\Sale\DomainModel\Identity\EmployeeId;

final class Cashier extends AggregateRoot implements Employee
{
    /**
     * @var mixed
     */
    private $id;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @param EmployeeId $id
     * @param FullName $name
     */
    public function __construct(EmployeeId $id, FullName $name)
    {
        $this->mutate(new CashierWasCreated($id, $name));
    }

    /**
     * @return EmployeeId
     */
    public function getIdentity()
    {
        return new EmployeeId($this->id);
    }

    /**
     * @param JobTitle $title
     *
     * @return bool
     */
    public function matchTitle(JobTitle $title)
    {
        return $title->equal(JobTitle::Cashier());
    }

    /**
     * @param CashierWasCreated $event
     */
    protected function onCashierWasCreated(CashierWasCreated $event)
    {
        $this->id = $event->employeeId()->id();
        $this->firstName = $event->name()->firstName();
        $this->lastName = $event->name()->lastName();
    }

    /**
     * @param EmployeeRole $role
     *
     * @return Receipt
     */
    public function receivePayment(OrderId $id, PaymentMethod $paymentMethod)
    {
        throw new \RuntimeException('Method ' . __METHOD__ . ' not implemented yet.');
    }
}
