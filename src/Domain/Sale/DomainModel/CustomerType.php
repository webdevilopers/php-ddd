<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Sale\DomainModel;

final class CustomerType
{
    /**
     * @return CustomerType
     */
    public static function PhoneCustomer()
    {
        return new self();
    }
}
