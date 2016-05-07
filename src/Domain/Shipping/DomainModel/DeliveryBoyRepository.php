<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Shipping\DomainModel;

interface DeliveryBoyRepository
{
    /**
     * @param DeliveryBoy $deliveryBoy
     */
    public function saveDeliveryBoy(DeliveryBoy $deliveryBoy);
}
