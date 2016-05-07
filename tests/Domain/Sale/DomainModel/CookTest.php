<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Sale\DomainModel;

use Example\Domain\Common\DomainModel\FullName;
use Example\Domain\Common\DomainModel\JobTitle;
use Example\Domain\Sale\DomainModel\Event\CookWasCreated;
use Example\Domain\Sale\DomainModel\Identity\EmployeeId;

final class CookTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Cook
     */
    private $cook;

    public function setUp()
    {
        $this->cook = new Cook(new EmployeeId(123), FullName::fromString('Joe', 'Blow'));
    }

    public function test_it_should_have_an_identity()
    {
        $this->assertEquals(new EmployeeId(123), $this->cook->getIdentity());
        $this->assertSame(123, $this->cook->getIdentity()->id());
    }

    public function test_it_should_match_title()
    {
        $this->assertTrue($this->cook->matchTitle(JobTitle::Cook()));
        $this->assertFalse($this->cook->matchTitle(JobTitle::Cashier()));
    }

    public function test_it_should_generate_an_event_on_creation()
    {
        $events = $this->cook->uncommitedEvents();
        $this->assertCount(1, $events);
        /**
         * @var CookWasCreated $event
         */
        $event = $events[0];
        $this->assertInstanceOf(CookWasCreated::class, $event);
        $this->assertEquals(new EmployeeId(123), $event->employeeId());
        $this->assertEquals(FullName::fromString('Joe', 'Blow'), $event->name());
    }
}
