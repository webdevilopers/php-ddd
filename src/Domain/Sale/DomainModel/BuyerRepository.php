<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Sale\DomainModel;

use Example\Domain\Common\Exception\EntityNotFoundException;

interface BuyerRepository
{
    /**
     * @param Buyer $buyer
     */
    public function saveBuyer(Buyer $buyer);

    /**
     * @param BuyerId $id
     *
     * @return Buyer
     * @throws EntityNotFoundException
     */
    public function buyerWithId(BuyerId $id);
}
