<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Sale\DomainModel\Event;

use Example\Domain\Common\DomainModel\Event\DomainEvent;
use Example\Domain\Sale\DomainModel\BuyerId;
use Example\Domain\Sale\DomainModel\Identity\EmployeeId;
use Example\Domain\Sale\DomainModel\Identity\OrderId;

final class OrderWasCreated implements DomainEvent
{
    /**
     * @var OrderId
     */
    private $orderId;

    /**
     * @var EmployeeId
     */
    private $employeeId;

    /**
     * @var BuyerId
     */
    private $buyerId;

    /**
     * @param OrderId $id
     * @param EmployeeId $employeeId
     * @param BuyerId $buyerId
     */
    public function __construct(OrderId $id, EmployeeId $employeeId, BuyerId $buyerId)
    {
        $this->orderId = $id;
        $this->employeeId = $employeeId;
        $this->buyerId = $buyerId;
    }

    /**
     * @return OrderId
     */
    public function orderId()
    {
        return $this->orderId;
    }

    /**
     * @return \Example\Domain\Sale\DomainModel\Identity\EmployeeId
     */
    public function employeeId()
    {
        return $this->employeeId;
    }

    /**
     * @return \Example\Domain\Sale\DomainModel\BuyerId
     */
    public function buyerId()
    {
        return $this->buyerId;
    }
}
