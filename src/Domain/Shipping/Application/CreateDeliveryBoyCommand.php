<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Shipping\Application;

use Example\Domain\Common\Application\DomainCommand;
use Example\Domain\Common\DomainModel\FullName;

final class CreateDeliveryBoyCommand implements DomainCommand
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
     * @return FullName
     */
    public function name()
    {
        return $this->name;
    }
}
