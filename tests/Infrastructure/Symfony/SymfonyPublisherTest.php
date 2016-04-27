<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Infrastructure\Symfony;

use Example\Domain\Common\DomainModel\Event\DomainEvent;

final class SymfonyPublisherTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SymfonyPublisher
     */
    private $symfonyPublisher;

    /**
     * @var bool
     */
    private $triggered = false;

    public function setUp()
    {
        $this->symfonyPublisher = new SymfonyPublisher();
    }

    public function test_it_should_publish_event_to_listener()
    {
        $this->symfonyPublisher->addListener(FakeEvent::class, $this, 'setTriggered');
        $this->assertFalse($this->triggered);
        $this->symfonyPublisher->publish([new FakeEvent()]);
        $this->assertTrue($this->triggered);
    }

    public function setTriggered(FakeEvent $event)
    {
        $this->triggered = true;
    }
}

final class FakeEvent implements DomainEvent
{
}
