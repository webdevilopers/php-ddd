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
use Example\Domain\Sale\DomainModel\Event\WaitressWasCreated;
use Example\Domain\Sale\DomainModel\Identity\EmployeeId;

final class Waitress extends AggregateRoot implements Employee
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
        $this->mutate(new WaitressWasCreated($id, $name));
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
        return $title->equal(JobTitle::Waitress());
    }

    /**
     * @param WaitressWasCreated $event
     */
    protected function onWaitressWasCreated(WaitressWasCreated $event)
    {
        $this->id = $event->employeeId()->id();
        $this->firstName = $event->name()->firstName();
        $this->lastName = $event->name()->lastName();
    }

    /**
     * @param ItemId $itemId
     * @param int $quantity
     *
     * @return Order
     */
    public function takeOrder(ItemId $itemId, $quantity)
    {
        throw new \RuntimeException('Method ' . __METHOD__ . ' not implemented yet.');
    }

    /**
     * @param ItemId $itemId
     * @param int $quantity
     *
     * @return Order
     */
    public function cancelItem(OrderId $orderId, ItemId $itemId, $quantity)
    {
        throw new \RuntimeException('Method ' . __METHOD__ . ' not implemented yet.');
    }

    /**
     * @param ItemId $itemId
     * @param int $quantity
     *
     * @return Order
     */
    public function addItem(OrderId $orderId, ItemId $itemId, $quantity)
    {
        throw new \RuntimeException('Method ' . __METHOD__ . ' not implemented yet.');
    }
}
