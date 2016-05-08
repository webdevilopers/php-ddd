<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Sale\DomainModel;

use Example\Domain\Common\DomainModel\AggregateRoot;
use Example\Domain\Common\DomainModel\Event\DomainEvent;
use Example\Domain\Sale\DomainModel\Event\OrderWasCreated;
use Example\Domain\Sale\DomainModel\Identity\EmployeeId;
use Example\Domain\Sale\DomainModel\Identity\OrderId;

final class Order extends AggregateRoot
{
    /**
     * @var mixed
     */
    private $id;

    /**
     * @var mixed
     */
    private $employeeId;

    /**
     * @var Buyer
     */
    private $buyer;

    /**
     * @param DomainEvent[] $events
     */
    private function __construct(array $events = [])
    {
        foreach ($events as $event) {
            $this->mutate($event);
        }
    }

    /**
     * @return OrderId
     */
    public function getIdentity()
    {
        return new OrderId($this->id);
    }

    /**
     * @param MEal $meal
     */
    public function orderMeal(MEal $meal)
    {

    }

    /**
     * @param OrderWasCreated $event
     */
    protected function onOrderWasCreated(OrderWasCreated $event)
    {
        $this->id = $event->orderId()->id();
        $this->employeeId = $event->employeeId()->id();
    }

    /**
     * @param OrderId $id
     * @param EmployeeId $employeeId
     * @param Buyer $buyer
     *
     * @return Order
     */
    public static function PhoneOrder(OrderId $id, EmployeeId $employeeId, Buyer $buyer)
    {
        $order = new self(
            [
                new OrderWasCreated($id, $employeeId, $buyer->getIdentity()),
            ]
        );
        $order->buyer = $buyer;

        return $order;
    }
}
