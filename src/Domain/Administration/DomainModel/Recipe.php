<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Administration\DomainModel;

use Example\Domain\Common\DomainModel\Money;

/**
 * Entity part of the Owner aggregate root
 */
final class Recipe implements RecipeContext
{
    /**
     * @var Owner
     */
    private $creator;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $price;

    /**
     * @var string
     */
    private $status;

    /**
     * @param Owner $creator
     * @param RecipeName $name
     * @param Money $price
     */
    public function __construct(Owner $creator, RecipeName $name, Money $price)
    {
        $this->creator = $creator;
        $this->name = $name->toString();
        $this->price = $price->amount();
        $this->setState(new PendingStatus());
    }

    /**
     * @return RecipeId
     */
    public function getIdentity()
    {
        return new RecipeId($this->name());
    }

    /**
     * @return bool
     */
    public function isReleased()
    {
        return RecipeStatus::fromString($this->status)->isReleased();
    }

    /**
     * @return bool
     */
    public function isRetired()
    {
        return RecipeStatus::fromString($this->status)->isRetired();
    }

    /**
     * @return bool
     */
    public function isPending()
    {
        return RecipeStatus::fromString($this->status)->isPending();
    }

    /**
     * @return Money
     */
    public function price()
    {
        return Money::fromInt($this->price);
    }

    /**
     * @return RecipeName
     */
    public function name()
    {
        return RecipeName::fromString($this->name);
    }

    public function release()
    {
        RecipeStatus::fromString($this->status)->release($this);
    }

    public function retire()
    {
        RecipeStatus::fromString($this->status)->retire($this);
    }

    /**
     * @param RecipeId $id
     *
     * @return bool
     */
    public function matchIdentity(RecipeId $id)
    {
        return $this->getIdentity() == $id;
    }

    /**
     * @param RecipeStatus $status
     *
     * @internal Used by state machine only
     */
    public function setState(RecipeStatus $status)
    {
        $this->status = $status->toString();
    }
}
