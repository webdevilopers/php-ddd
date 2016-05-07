<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Common\Application;

use Example\Domain\Common\DomainModel\Event\DomainEvent;

interface EventPublisher
{
    /**
     * @param DomainEvent[] $events
     */
    public function publish(array $events);

    /**
     * @param string $eventClassName The class full name of the event
     * @param callable $listener An object that listens on events
     * @param string $method
     */
    public function addListener($eventClassName, $listener, $method);
}
