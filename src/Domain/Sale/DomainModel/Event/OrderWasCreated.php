<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Sale\DomainModel\Event;

use Example\Domain\Common\DomainModel\Event\DomainEvent;
use Example\Domain\Sale\DomainModel\Buyer;
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
     * @var Buyer
     */
    private $buyer;

    /**
     * @param OrderId $id
     * @param EmployeeId $employeeId
     * @param Buyer $buyer
     */
    public function __construct(OrderId $id, EmployeeId $employeeId, Buyer $buyer)
    {
        $this->orderId = $id;
        $this->employeeId = $employeeId;
        $this->buyer = $buyer;
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
        return $this->buyer->getIdentity();
    }

    /**
     * @return Buyer
     *
     * @internal Should not be used for operation.
     */
    public function _buyer()
    {
        return $this->buyer;
    }
}
