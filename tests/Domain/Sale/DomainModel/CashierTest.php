<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Sale\DomainModel;

use Example\Domain\Common\DomainModel\FullName;
use Example\Domain\Common\DomainModel\JobTitle;
use Example\Domain\Sale\DomainModel\Event\CashierWasCreated;
use Example\Domain\Sale\DomainModel\Identity\EmployeeId;

final class CashierTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Cashier
     */
    private $cashier;

    public function setUp()
    {
        $this->cashier = new Cashier(new EmployeeId(123), FullName::fromString('Joe', 'Blow'));
    }

    public function test_it_should_have_an_identity()
    {
        $this->assertEquals(new EmployeeId(123), $this->cashier->getIdentity());
        $this->assertSame(123, $this->cashier->getIdentity()->id());
    }

    public function test_it_should_match_title()
    {
        $this->assertFalse($this->cashier->matchTitle(JobTitle::Cook()));
        $this->assertTrue($this->cashier->matchTitle(JobTitle::Cashier()));
    }

    public function test_it_should_generate_an_event_on_creation()
    {
        $events = $this->cashier->uncommitedEvents();
        $this->assertCount(1, $events);
        /**
         * @var CashierWasCreated $event
         */
        $event = $events[0];
        $this->assertInstanceOf(CashierWasCreated::class, $event);
        $this->assertEquals(new EmployeeId(123), $event->employeeId());
        $this->assertEquals(FullName::fromString('Joe', 'Blow'), $event->name());
    }
}
