<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Infrastructure\InMemory\Sale;

use Example\Domain\Common\Exception\EntityNotFoundException;
use Example\Domain\Sale\DomainModel\Buyer;
use Example\Domain\Sale\DomainModel\BuyerId;
use Example\Domain\Sale\DomainModel\BuyerRepository;

final class BuyerCollection implements BuyerRepository
{
    /**
     * @var Buyer[]
     */
    private $buyers = [];

    /**
     * @param Buyer $buyer
     */
    public function saveBuyer(Buyer $buyer)
    {
        $this->buyers[$buyer->getIdentity()->id()] = $buyer;
    }

    /**
     * @param BuyerId $id
     *
     * @return Buyer
     * @throws EntityNotFoundException
     */
    public function buyerWithId(BuyerId $id)
    {
        if (! isset($this->buyers[$id->id()])) {

        }

        return $this->buyers[$id->id()];
    }
}
