<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Sale\DomainModel;

use Example\Domain\Common\DomainModel\FullName;
use Example\Domain\Common\DomainModel\JobTitle;
use Example\Domain\Sale\DomainModel\Event\WaitressWasCreated;
use Example\Domain\Sale\DomainModel\Identity\EmployeeId;

final class WaitressTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Waitress
     */
    private $waitress;

    public function setUp()
    {
        $this->waitress = new Waitress(new EmployeeId(123), FullName::fromString('Joe', 'Blow'));
    }

    public function test_it_should_have_an_identity()
    {
        $this->assertEquals(new EmployeeId(123), $this->waitress->getIdentity());
        $this->assertSame(123, $this->waitress->getIdentity()->id());
    }

    public function test_it_should_match_title()
    {
        $this->assertTrue($this->waitress->matchTitle(JobTitle::Waitress()));
        $this->assertFalse($this->waitress->matchTitle(JobTitle::Cashier()));
    }

    public function test_it_should_generate_an_event_on_creation()
    {
        $events = $this->waitress->uncommitedEvents();
        $this->assertCount(1, $events);
        /**
         * @var WaitressWasCreated $event
         */
        $event = $events[0];
        $this->assertInstanceOf(WaitressWasCreated::class, $event);
        $this->assertEquals(new EmployeeId(123), $event->employeeId());
        $this->assertEquals(FullName::fromString('Joe', 'Blow'), $event->name());
    }
}
