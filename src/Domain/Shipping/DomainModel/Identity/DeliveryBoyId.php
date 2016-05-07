<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Shipping\DomainModel\Identity;

use Example\Domain\Common\DomainModel\FullName;
use Example\Domain\Common\DomainModel\Identity\Identity;
use Example\Domain\Shipping\DomainModel\DeliveryBoy;

final class DeliveryBoyId implements Identity
{
    /**
     * @var FullName
     */
    private $name;

    /**
     * @param FullName $name
     */
    public function __construct(FullName $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEntityClass()
    {
        return DeliveryBoy::class;
    }

    /**
     * @return mixed
     */
    public function id()
    {
        return '[Delivery boy] ' . $this->name->toString();
    }
}
