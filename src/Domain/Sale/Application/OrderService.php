<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Sale\Application;

use Example\Domain\Common\Application\EventPublisher;
use Example\Domain\Sale\DomainModel\BuyerId;
use Example\Domain\Sale\DomainModel\BuyerRepository;
use Example\Domain\Sale\DomainModel\ConfirmationNumberGenerator;
use Example\Domain\Sale\DomainModel\CustomerType;
use Example\Domain\Sale\DomainModel\Identity\EmployeeId;
use Example\Domain\Sale\DomainModel\Identity\MealId;
use Example\Domain\Sale\DomainModel\Identity\OrderId;
use Example\Domain\Sale\DomainModel\MealRepository;
use Example\Domain\Sale\DomainModel\OrderRepository;

final class OrderService
{
    /**
     * @var OrderRepository
     */
    private $orders;

    /**
     * @var EventPublisher
     */
    private $publisher;

    /**
     * @var BuyerRepository
     */
    private $buyers;

    /**
     * @var MealRepository
     */
    private $meals;

    /**
     * @var ConfirmationNumberGenerator
     */
    private $generator;

    /**
     * @param OrderRepository $orders
     * @param EventPublisher $publisher
     * @param BuyerRepository $buyers
     * @param MealRepository $meals
     * @param ConfirmationNumberGenerator $generator
     */
    public function __construct(
        OrderRepository $orders,
        EventPublisher $publisher,
        BuyerRepository $buyers,
        MealRepository $meals,
        ConfirmationNumberGenerator $generator
    ) {
        $this->orders = $orders;
        $this->publisher = $publisher;
        $this->buyers = $buyers;
        $this->meals = $meals;
        $this->generator = $generator;
    }

    /**
     * @param EmployeeId $waitress
     * @param CustomerType $type
     * @param BuyerId $buyerId
     */
    public function startOrder(EmployeeId $waitress, CustomerType $type, BuyerId $buyerId)
    {
        $order = $type->startOrder(
            $this->generator->generateOrderId(),
            $waitress,
            $this->buyers->buyerWithId($buyerId)
        );
        $this->orders->saveOrder($order);

        $this->publisher->publish($order->uncommitedEvents());
    }

    /**
     * @param OrderId $orderId
     * @param int $quantity
     * @param MealId $mealId
     */
    public function orderMeal(OrderId $orderId, $quantity, MealId $mealId)
    {
        $order = $this->orders->orderWithId($orderId);
        $meal = $this->meals->activeMeal($mealId);
        for ($i = 0; $i < $quantity; $i ++) {
            $order->orderMeal($meal);
        }

        $this->orders->saveOrder($order);
        $this->publisher->publish($order->uncommitedEvents());
    }

    public function confirmOrder(OrderId $orderId, \DateTime $time)
    {
        throw new \RuntimeException(__METHOD__ . ' is not implemented yet.');
    }
}
