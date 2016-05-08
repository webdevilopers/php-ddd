<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Sale\DomainModel;

use Example\Domain\Sale\DomainModel\Identity\OrderId;

interface ConfirmationNumberGenerator
{
    /**
     * @return OrderId
     */
    public function generateOrderId();
}
