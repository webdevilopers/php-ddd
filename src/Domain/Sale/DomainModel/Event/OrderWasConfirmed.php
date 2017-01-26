<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Sale\DomainModel\Event;

use Example\Domain\Common\DomainModel\Event\DomainEvent;
use Example\Domain\Sale\DomainModel\Identity\OrderId;

final class OrderWasConfirmed implements DomainEvent
{
    /**
     * @var OrderId
     */
    private $orderId;

    /**
     * @param OrderId $orderId
     */
    public function __construct(OrderId $orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * @return OrderId
     */
    public function orderId()
    {
        return $this->orderId;
    }
}
