<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Sale\DomainModel;

use Example\Domain\Common\DomainModel\AggregateRoot;
use Example\Domain\Common\DomainModel\Event\DomainEvent;
use Example\Domain\Sale\DomainModel\Event\MealWasOrdered;
use Example\Domain\Sale\DomainModel\Event\OrderWasConfirmed;
use Example\Domain\Sale\DomainModel\Event\OrderWasCreated;
use Example\Domain\Sale\DomainModel\Identity\EmployeeId;
use Example\Domain\Sale\DomainModel\Identity\MealId;
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
     * @var Meal[]
     */
    private $meals = [];

    /**
     * @var bool
     */
    private $isConfirmed = false;

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
     * @return BuyerId
     */
    public function buyerId()
    {
        return $this->buyer->getIdentity();
    }

    /**
     * @return EmployeeId
     */
    public function takenBy()
    {
        return EmployeeId::fromString($this->employeeId);
    }

    /**
     * @return bool
     */
    public function isConfirmed()
    {
        return $this->isConfirmed;
    }

    /**
     * @param Meal $meal
     */
    public function orderMeal(Meal $meal)
    {
        $this->mutate(new MealWasOrdered($this->getIdentity(), $meal));
    }

    /**
     * @return MealId[]
     */
    public function orderedMeals()
    {
        return array_map(
            function (Meal $meal) {
                return $meal->getIdentity();
            },
            $this->meals
        );
    }

    /**
     * @param MealWasOrdered $event
     */
    protected function onMealWasOrdered(MealWasOrdered $event)
    {
        $this->meals[] = $event->_meal();
    }

    /**
     * @param OrderWasCreated $event
     */
    protected function onOrderWasCreated(OrderWasCreated $event)
    {
        $this->id = $event->orderId()->id();
        $this->employeeId = $event->employeeId()->id();
        $this->buyer = $event->_buyer();
    }

    /**
     * @param OrderWasConfirmed $event
     * @throws OrderException
     */
    protected function onOrderWasConfirmed(OrderWasConfirmed $event)
    {
        if ($this->isConfirmed()) {
            throw new OrderException('Cannot confirm an order twice.');
        }

        $this->isConfirmed = true;
    }

    /**
     * @param OrderId $id
     * @param EmployeeId $takenBy
     * @param Buyer $buyer
     *
     * @return Order
     */
    public static function PendingOrder(OrderId $id, EmployeeId $takenBy, Buyer $buyer)
    {
        return new self(
            [
                new OrderWasCreated($id, $takenBy, $buyer),
            ]
        );
   }

    /**
     * @param OrderId $id
     * @param EmployeeId $takenBy
     * @param Buyer $buyer
     *
     * @return Order
     */
    public static function ConfirmedOrder(OrderId $id, EmployeeId $takenBy, Buyer $buyer)
    {
        $order = self::PendingOrder($id, $takenBy, $buyer);
        $order->mutate(new OrderWasConfirmed($id));

        return $order;
    }

    /**
     * @param DomainEvent[] $events
     *
     * @return Order
     */
    public static function fromStream(array $events)
    {
        return new self($events);
    }
}
