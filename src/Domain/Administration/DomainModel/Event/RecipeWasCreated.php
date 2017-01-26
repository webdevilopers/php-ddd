<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Administration\DomainModel\Event;

use Example\Domain\Administration\DomainModel\Identity\OwnerId;
use Example\Domain\Administration\DomainModel\RecipeId;
use Example\Domain\Administration\DomainModel\RecipeName;
use Example\Domain\Common\DomainModel\Event\DomainEvent;
use Example\Domain\Common\DomainModel\Money;

final class RecipeWasCreated implements DomainEvent
{
    /**
     * @var OwnerId
     */
    private $creator;

    /**
     * @var RecipeId
     */
    private $recipeId;

    /**
     * @var RecipeName
     */
    private $name;

    /**
     * @var Money
     */
    private $price;

    public function __construct(OwnerId $creator, RecipeId $id, RecipeName $name, Money $price)
    {
        $this->creator = $creator;
        $this->recipeId = $id;
        $this->name = $name;
        $this->price = $price;
    }

    /**
     * @return \Example\Domain\Administration\DomainModel\RecipeId
     */
    public function recipeId()
    {
        return $this->recipeId;
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
