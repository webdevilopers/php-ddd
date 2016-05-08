<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Administration\DomainModel\Event;

use Example\Domain\Administration\DomainModel\RecipeId;
use Example\Domain\Common\DomainModel\Event\DomainEvent;

final class RecipeWasRetired implements DomainEvent
{
    /**
     * @var RecipeId
     */
    private $recipeId;

    public function __construct(RecipeId $recipeId)
    {
        $this->recipeId = $recipeId;
    }

    /**
     * @return RecipeId
     */
    public function recipeId()
    {
        return $this->recipeId;
    }
}
