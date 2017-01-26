<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Sale\DomainModel;

use Example\Domain\Common\Exception\EntityNotFoundException;
use Example\Domain\Sale\DomainModel\Identity\OrderId;

interface OrderRepository
{
    /**
     * @param Order $order
     */
    public function saveOrder(Order $order);

    /**
     * @param OrderId $id
     *
     * @return Order
     * @throws EntityNotFoundException
     */
    public function orderWithId(OrderId $id);
}
