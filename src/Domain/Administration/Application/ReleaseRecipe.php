<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Administration\Application;

use Example\Domain\Administration\DomainModel\Identity\OwnerId;
use Example\Domain\Administration\DomainModel\RecipeId;

final class ReleaseRecipe
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
     * @param OwnerId $creator
     * @param RecipeId $recipeId
     */
    public function __construct(OwnerId $creator, RecipeId $recipeId)
    {
        $this->creator = $creator;
        $this->recipeId = $recipeId;
    }

    /**
     * @return \Example\Domain\Administration\DomainModel\Identity\OwnerId
     */
    public function creator()
    {
        return $this->creator;
    }

    /**
     * @return \Example\Domain\Administration\DomainModel\RecipeId
     */
    public function recipeId()
    {
        return $this->recipeId;
    }
}
