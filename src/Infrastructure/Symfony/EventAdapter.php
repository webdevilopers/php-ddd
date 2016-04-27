<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Infrastructure\Symfony;

use Example\Domain\Common\DomainModel\Event\DomainEvent;
use Symfony\Component\EventDispatcher\Event;

final class EventAdapter extends Event
{
    /**
     * @var DomainEvent
     */
    private $event;

    /**
     * @param DomainEvent $event
     */
    public function __construct(DomainEvent $event)
    {
        $this->event = $event;
    }

    public function getName()
    {
        return get_class($this->event);
    }

    /**
     * @return DomainEvent
     */
    public function getWrappedEvent()
    {
        return $this->event;
    }
}
