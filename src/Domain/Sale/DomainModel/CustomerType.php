<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Sale\DomainModel;

use Example\Domain\Sale\DomainModel\Identity\EmployeeId;
use Example\Domain\Sale\DomainModel\Identity\OrderId;

abstract class CustomerType
{
    /**
     * @param OrderId $orderId
     * @param EmployeeId $employeeId
     * @param Buyer $buyer
     *
     * @return Order
     */
    public abstract function startOrder(OrderId $orderId, EmployeeId $employeeId, Buyer $buyer);

    /**
     * @return CustomerType
     */
    public static function PhoneCustomer()
    {
        return new PhoneCustomer();
    }
}
