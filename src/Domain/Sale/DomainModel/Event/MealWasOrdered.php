<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Sale\DomainModel\Event;

use Example\Domain\Common\DomainModel\Event\DomainEvent;
use Example\Domain\Sale\DomainModel\Identity\MealId;
use Example\Domain\Sale\DomainModel\Identity\OrderId;
use Example\Domain\Sale\DomainModel\Meal;

final class MealWasOrdered implements DomainEvent
{
    /**
     * @var OrderId
     */
    private $orderId;

    /**
     * @var Meal
     */
    private $meal;

    /**
     * @param OrderId $orderId
     * @param Meal $meal
     */
    public function __construct(OrderId $orderId, Meal $meal)
    {
        $this->orderId = $orderId;
        $this->meal = $meal;
    }

    /**
     * @return \Example\Domain\Sale\DomainModel\Identity\MealId
     */
    public function mealId()
    {
        return $this->meal->getIdentity();
    }

    /**
     * @return \Example\Domain\Sale\DomainModel\Identity\OrderId
     */
    public function orderId()
    {
        return $this->orderId;
    }

    /**
     * @internal Should not be used to perform operation
     */
    public function _meal()
    {
        return $this->meal;
    }
}
