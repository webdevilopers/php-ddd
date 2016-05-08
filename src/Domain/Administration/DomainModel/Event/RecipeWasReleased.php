<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Administration\DomainModel\Event;

use Example\Domain\Administration\DomainModel\RecipeId;
use Example\Domain\Common\DomainModel\Event\DomainEvent;

final class RecipeWasReleased implements DomainEvent
{
    /**
     * @var RecipeId
     */
    private $recipeId;

    /**
     * @var string
     */
    private $recipeName;

    /**
     * @param RecipeId $recipeId
     * @param string $recipeName
     */
    public function __construct(RecipeId $recipeId, $recipeName)
    {
        $this->recipeId = $recipeId;
        $this->recipeName = $recipeName;
    }

    /**
     * @return RecipeId
     */
    public function recipeId()
    {
        return $this->recipeId;
    }

    /**
     * @return string
     */
    public function recipeName()
    {
        return $this->recipeName;
    }
}
