<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Sale\DomainModel;

use Example\Domain\Sale\DomainModel\Event\OrderWasCreated;
use Example\Domain\Sale\DomainModel\Identity\EmployeeId;
use Example\Domain\Sale\DomainModel\Identity\OrderId;

final class PhoneOrderTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_should_create_a_phone_order_with_id()
    {
        $order = Order::PhoneOrder(
            new OrderId(123),
            new EmployeeId('employee'),
            Buyer::PhoneBuyer(PhoneNumber::fromString('555-5555', 'CA'), Address::fromString(''))
        );
        $this->assertInstanceOf(Order::class, $order);
        $events = $order->uncommitedEvents();
        $this->assertCount(1, $events);

        /**
         * @var OrderWasCreated $event
         */
        $event = $events[0];
        $this->assertInstanceOf(OrderWasCreated::class, $event);
        $this->assertSame(123, $event->orderId()->id());
        $this->assertSame(Order::class, $event->orderId()->getEntityClass());
        $this->assertSame('employee', $event->employeeId()->id());
        $this->assertSame('555-5555', $event->buyerId()->id());
    }
}
