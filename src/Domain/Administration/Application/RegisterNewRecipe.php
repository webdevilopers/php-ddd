<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Administration\Application;

use Example\Domain\Administration\DomainModel\Identity\OwnerId;
use Example\Domain\Administration\DomainModel\RecipeName;
use Example\Domain\Common\DomainModel\Money;

final class RegisterNewRecipe
{
    /**
     * @var OwnerId
     */
    private $creator;

    /**
     * @var RecipeName
     */
    private $name;

    /**
     * @var Money
     */
    private $price;

    /**
     * @param OwnerId $creator
     * @param RecipeName $name
     * @param Money $price
     */
    public function __construct(OwnerId $creator, RecipeName $name, Money $price)
    {
        $this->creator = $creator;
        $this->name = $name;
        $this->price = $price;
    }

    /**
     * @return \Example\Domain\Administration\DomainModel\Identity\OwnerId
     */
    public function creator()
    {
        return $this->creator;
    }

    /**
     * @return \Example\Domain\Common\DomainModel\RecipeName
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return \Example\Domain\Common\DomainModel\Money
     */
    public function price()
    {
        return $this->price;
    }
}
