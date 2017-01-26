<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Sale\DomainModel;

use Example\Domain\Sale\DomainModel\Event\OrderWasConfirmed;
use Example\Domain\Sale\DomainModel\Event\OrderWasCreated;
use Example\Domain\Sale\DomainModel\Identity\EmployeeId;
use Example\Domain\Sale\DomainModel\Identity\MealId;
use Example\Domain\Sale\DomainModel\Identity\OrderId;

final class OrderTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_should_create_a_pending_order_with_id()
    {
        $order = Order::PendingOrder(
            new OrderId(123),
            new EmployeeId('employee'),
            $buyer = new NullBuyer()
        );
        $this->assertInstanceOf(Order::class, $order);
        $events = $order->uncommitedEvents();
        $this->assertFalse($order->isConfirmed());

        $this->assertCount(1, $events);

        /**
         * @var OrderWasCreated $event
         */
        $event = $events[0];
        $this->assertInstanceOf(OrderWasCreated::class, $event);
        $this->assertSame(123, $event->orderId()->id());
        $this->assertSame(Order::class, $event->orderId()->getEntityClass());
        $this->assertSame('employee', $event->employeeId()->id());
        $this->assertSame($buyer->getIdentity(), $event->buyerId());
    }

    public function test_it_should_create_a_confirmed_order()
    {
        $order = Order::ConfirmedOrder(
            $orderId = new OrderId(1), $employee = new EmployeeId(1), $buyer = new NullBuyer()
        );
        $this->assertInstanceOf(Order::class, $order);
        $this->assertTrue($order->isConfirmed());
        $this->assertEquals($buyer->getIdentity(), $order->buyerId());
        $this->assertEquals($employee, $order->takenBy());
        $this->assertEquals($orderId, $order->getIdentity());

        $events = $order->uncommitedEvents();
        $this->assertInstanceOf(OrderWasCreated::class, $events[0]);
        $this->assertInstanceOf(OrderWasConfirmed::class, $events[1]);
    }

    public function test_it_should_add_meal_to_order()
    {
        $order = Order::PendingOrder(new OrderId(1), new EmployeeId(1), new NullBuyer());
        $this->assertEquals([], $order->orderedMeals());
        $order->orderMeal(new Meal($orderOne = new MealId('meal 1'), 'Sandwich'));
        $this->assertEquals([$orderOne], $order->orderedMeals());
        $order->orderMeal(new Meal($orderTwo = new MealId('meal 2'), 'Burger'));
        $this->assertEquals([$orderOne, $orderTwo], $order->orderedMeals());
    }

    /**
     * @expectedException        \Example\Domain\Sale\DomainModel\OrderException
     * @expectedExceptionMessage Cannot confirm an order twice.
     */
    public function test_it_should_not_allow_to_confirm_order_twice()
    {
        Order::fromStream(
            [
                new OrderWasConfirmed(new OrderId(1)),
                new OrderWasConfirmed(new OrderId(1)),
            ]
        );
    }

    public function test_confirming_the_order_should_start_preparation_of_order()
    {
        $order = Order::PendingOrder(new OrderId(1), new EmployeeId(1), new NullBuyer());
        $this->assertFalse($order->isConfirmed());
        $scheduledOrder = $order->confirm(new \DateTime('2010-01-01 10:00:55'));

        $this->assertInstanceOf(ScheduleForCookingOrder::class, $scheduledOrder);
        $this->assertTrue($order->isConfirmed());
    }
}

final class NullBuyer implements Buyer
{
    /**
     * @var BuyerId
     */
    private $id;

    public function __construct()
    {
        $this->id = BuyerId::fromString(uniqid('buyer-'));
    }

    /**
     * @return BuyerId
     */
    public function getIdentity()
    {
        return $this->id;
    }
}
