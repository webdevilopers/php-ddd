<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Shipping\DomainModel;

use Example\Domain\Common\DomainModel\AggregateRoot;
use Example\Domain\Common\DomainModel\FullName;
use Example\Domain\Common\DomainModel\JobTitle;
use Example\Domain\Shipping\DomainModel\Identity\DeliveryBoyId;

final class DeliveryBoy extends AggregateRoot
{
    /**
     * @var string
     */
    private $id;

    /**
     * @param DeliveryBoyId $id
     */
    public function __construct(DeliveryBoyId $id)
    {
        $this->id = $id->id();
    }

    /**
     * @return DeliveryBoyId
     */
    public function getIdentity()
    {
        return new DeliveryBoyId(FullName::fromSingleString($this->id));
    }

    /**
     * @param JobTitle $title
     *
     * @return bool
     * todo part of employee interface, should not cross boundary
     */
    public function matchTitle(JobTitle $title)
    {
        return $title->equal(JobTitle::DeliveryBoy());
    }
}
