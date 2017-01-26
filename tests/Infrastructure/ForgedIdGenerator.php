<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Infrastructure;

use Example\Domain\Sale\DomainModel\ConfirmationNumberGenerator;
use Example\Domain\Sale\DomainModel\Identity\OrderId;

final class ForgedIdGenerator implements ConfirmationNumberGenerator
{
    /**
     * @var OrderId|null
     */
    private $orderId;

    /**
     * @param OrderId $id
     */
    public function returnsOrderIdOnNextCall(OrderId $id)
    {
        $this->orderId = $id;
    }

    /**
     * @return OrderId
     */
    public function generateOrderId()
    {
        return $this->orderId;
    }
}
