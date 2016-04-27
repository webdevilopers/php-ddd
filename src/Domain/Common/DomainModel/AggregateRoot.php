<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Common\DomainModel;

use Example\Domain\Common\DomainModel\Event\DomainEvent;

abstract class AggregateRoot
{
    /**
     * @var DomainEvent[]
     */
    private $mutations = [];

    /**
     * @return DomainEvent[]
     */
    public function uncommitedEvents() {
        $mutations = $this->mutations;
        $this->mutations = [];

        return $mutations;
    }

    /**
     * @param DomainEvent $event
     * @throws \RuntimeException
     */
    protected function mutate(DomainEvent $event)
    {
        $method = $this->getEventMethod($event);
        if (! method_exists($this, $method)) {
            throw new \RuntimeException("The mutation '{$method}' do not exists.");
        }

        $this->$method($event);
        $this->mutations[] = $event;
    }

    /**
     * @param DomainEvent $event
     *
     * @return string
     */
    private function getEventMethod(DomainEvent $event)
    {
        $class = get_class($event);
        $parts = explode('\\', $class);
        $name = array_pop($parts);
        $method = 'on' . $name;

        return $method;
    }
}
