<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Infrastructure\InMemory\Sale;

use Example\Domain\Common\Exception\EntityNotFoundException;
use Example\Domain\Sale\DomainModel\Identity\OrderId;
use Example\Domain\Sale\DomainModel\Order;
use Example\Domain\Sale\DomainModel\OrderRepository;

final class OrderCollection implements OrderRepository
{
    /**
     * @var Order[]
     */
    private $orders = [];

    /**
     * @param Order $order
     */
    public function saveOrder(Order $order)
    {
        $this->orders[$order->getIdentity()->id()] = $order;
    }

    /**
     * @param OrderId $id
     *
     * @return Order
     * @throws EntityNotFoundException
     */
    public function orderWithId(OrderId $id)
    {
        if (! isset($this->orders[$id->id()])) {
            throw EntityNotFoundException::entityWithIdentity($id);
        }

        return $this->orders[$id->id()];
    }
}
