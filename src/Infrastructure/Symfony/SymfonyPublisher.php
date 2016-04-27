<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Infrastructure\Symfony;

use Example\Domain\Common\Application\EventPublisher;
use Example\Domain\Common\DomainModel\Event\DomainEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;

final class SymfonyPublisher implements EventPublisher
{
    /**
     * @var EventDispatcher
     */
    private $dispatcher;

    public function __construct()
    {
        $this->dispatcher = new EventDispatcher();
    }

    /**
     * @param DomainEvent[] $events
     */
    public function publish(array $events)
    {
        foreach ($events as $event) {
            $eventAdapter = new EventAdapter($event);
            $this->dispatcher->dispatch($eventAdapter->getName(), $eventAdapter);
        }
    }

    /**
     * @param string $eventClassName The class full name of the event
     * @param callable $listener An object that listens on events
     * @param string $method
     */
    public function addListener($eventClassName, $listener, $method)
    {
        $transformer = function (EventAdapter $adapter) use ($listener, $method) {
            call_user_func([$listener, $method], $adapter->getWrappedEvent());
        };

        $this->dispatcher->addListener($eventClassName, $transformer);
    }
}
