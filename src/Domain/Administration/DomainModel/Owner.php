<?php

namespace Example\Domain\Administration\DomainModel;

use Example\Domain\Administration\DomainModel\Event\RecipeWasCreated;
use Example\Domain\Administration\DomainModel\Event\RecipeWasReleased;
use Example\Domain\Administration\DomainModel\Event\RecipeWasRetired;
use Example\Domain\Administration\DomainModel\Identity\OwnerId;
use Example\Domain\Administration\DomainModel\Event\CandidateWasHired;
use Example\Domain\Common\DomainModel\AggregateRoot;
use Example\Domain\Common\DomainModel\FullName;
use Example\Domain\Common\DomainModel\JobTitle;
use Example\Domain\Common\DomainModel\Money;
use Example\Domain\Common\Exception\EntityNotFoundException;

/**
 * Aggregate root of the admin context
 * This class manages:
 *
 * - Recipes
 * - Candidates
 */
final class Owner extends AggregateRoot
{
    /**
     * @var OwnerId
     */
    private $identity;

    /**
     * @var Candidate[]
     */
    private $candidates = [];

    /**
     * @var Recipe[]
     */
    private $recipes = [];

    /**
     * @param OwnerId $id
     */
    public function __construct(OwnerId $id)
    {
        $this->identity = $id;
    }

    /**
     * @return OwnerId
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     * @param FullName $name
     * @param JobTitle $title
     */
    public function hire(FullName $name, JobTitle $title)
    {
        $this->mutate(new CandidateWasHired($this->identity, $name, $title));
    }

    /**
     * @param RecipeName $name
     * @param Money $price
     */
    public function newRecipe(RecipeName $name, Money $price)
    {
        $this->mutate(
            new RecipeWasCreated(
                $this->getIdentity(), new RecipeId($name), $name, $price
            )
        );
    }

    /**
     * @param RecipeId $id
     */
    public function releaseRecipe(RecipeId $id)
    {
        $this->mutate(new RecipeWasReleased($id, $this->recipeWithId($id)->name()->toString()));
    }

    /**
     * @param RecipeId $id
     */
    public function retireRecipe(RecipeId $id)
    {
        $this->mutate(new RecipeWasRetired($id));
    }

    /**
     * @param RecipeId $id
     *
     * @throws \Example\Domain\Common\Exception\EntityNotFoundException
     * @return Recipe
     */
    public function recipeWithId(RecipeId $id)
    {
        foreach ($this->recipes as $recipe) {
            if ($recipe->matchIdentity($id)) {
                return $recipe;
            }
        }

        throw EntityNotFoundException::entityWithIdentity($id);
    }

    /**
     * @param CandidateWasHired $event
     */
    protected function onCandidateWasHired(CandidateWasHired $event)
    {
        $this->candidates[] = new Candidate($event->candidateName(), $event->title());
    }

    /**
     * @param RecipeWasCreated $event
     */
    protected function onRecipeWasCreated(RecipeWasCreated $event)
    {
        $this->recipes[] = new Recipe($this, $event->name(), $event->price());
    }

    /**
     * @param RecipeWasReleased $event
     */
    protected function onRecipeWasReleased(RecipeWasReleased $event)
    {
        $recipe = $this->recipeWithId($event->recipeId());
        $recipe->release();
    }

    /**
     * @param RecipeWasRetired $event
     */
    protected function onRecipeWasRetired(RecipeWasRetired $event)
    {
        $recipe = $this->recipeWithId($event->recipeId());
        $recipe->retire();
    }
}
