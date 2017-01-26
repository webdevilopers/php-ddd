<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Sale\Application;

use Example\Domain\Administration\DomainModel\Event\RecipeWasReleased;
use Example\Domain\Common\Application\EventPublisher;
use Example\Domain\Sale\DomainModel\Identity\MealId;
use Example\Domain\Sale\DomainModel\Meal;
use Example\Domain\Sale\DomainModel\MealRepository;

final class CreateMealOnRecipeCreated
{
    /**
     * @var MealRepository
     */
    private $meals;

    /**
     * @var EventPublisher
     */
    private $publisher;

    /**
     * @param MealRepository $meals
     * @param EventPublisher $publisher
     */
    public function __construct(MealRepository $meals, EventPublisher $publisher)
    {
        $this->meals = $meals;
        $publisher->addListener(RecipeWasReleased::class, $this, 'onRecipeWasReleased');
        $this->publisher = $publisher;
    }

    /**
     * @param RecipeWasReleased $event
     */
    public function onRecipeWasReleased(RecipeWasReleased $event)
    {
        $meal = new Meal(new MealId($event->recipeId()->id()), $event->recipeName());
        $this->meals->saveMeal($meal);

        $this->publisher->publish($meal->uncommitedEvents());
    }
}
