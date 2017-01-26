<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Administration\DomainModel;

use Example\Domain\Administration\DomainModel\Event\CandidateWasHired;
use Example\Domain\Administration\DomainModel\Event\RecipeWasCreated;
use Example\Domain\Administration\DomainModel\Event\RecipeWasReleased;
use Example\Domain\Administration\DomainModel\Event\RecipeWasRetired;
use Example\Domain\Administration\DomainModel\Identity\OwnerId;
use Example\Domain\Common\DomainModel\FullName;
use Example\Domain\Common\DomainModel\JobTitle;
use Example\Domain\Common\DomainModel\Money;

final class OwnerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Owner
     */
    private $owner;

    public function setUp()
    {
        $this->owner = new Owner(new OwnerId(FullName::fromSingleString('owner')));
    }

    public function test_it_should_create_a_owner()
    {
        $this->assertSame(FullName::fromSingleString('owner')->toString(), $this->owner->getIdentity()->id());
    }

    public function test_it_should_hire_candidate()
    {
        $this->owner->hire(FullName::fromSingleString('candidate'), JobTitle::Cashier());
        $events = $this->owner->uncommitedEvents();
        $this->assertCount(1, $events);
        $event = $events[0];
        /**
         * @var $event CandidateWasHired
         */
        $this->assertInstanceOf(CandidateWasHired::class, $event);
        $this->assertEquals(FullName::fromSingleString('candidate'), $event->candidateName());
        $this->assertEquals($this->owner->getIdentity(), $event->hiredBy());
        $this->assertEquals(JobTitle::Cashier(), $event->title());
    }

    /**
     * @depends test_it_should_create_a_owner
     */
    public function test_it_should_create_new_recipe()
    {
        $this->owner->uncommitedEvents(); // reset
        $this->owner->newRecipe(RecipeName::fromString('All dress Pizza'), Money::fromInt(1200));

        $events = $this->owner->uncommitedEvents();
        $this->assertCount(1, $events, 'event should be added');
        /**
         * @var RecipeWasCreated $event
         */
        $event = $events[0];
        $this->assertInstanceOf(RecipeWasCreated::class, $event);
        $this->assertEquals($this->owner->getIdentity(), $event->creator(), 'The creator id should be defined');
        $this->assertInstanceOf(RecipeId::class, $event->recipeId(), 'The recipe id should be defined');
        $this->assertEquals(Money::fromInt(1200), $event->price(), 'The price should be defined');

        $recipe = $this->owner->recipeWithId($event->recipeId());
        $this->assertInstanceOf(Recipe::class, $recipe, 'Owner should create recipe');
        $this->assertFalse($recipe->isReleased(), 'Recipe should not be released by default');
        $this->assertFalse($recipe->isRetired(), 'Recipe should not be retired by default');
        $this->assertEquals(Money::fromInt(1200), $recipe->price());
        $this->assertEquals(RecipeName::fromString('All dress Pizza'), $recipe->name());
    }

    /**
     * @depends test_it_should_create_new_recipe
     */
    public function test_it_should_release_recipe()
    {
        $this->owner->uncommitedEvents(); // reset
        $this->owner->newRecipe(RecipeName::fromString('All dress Pizza'), Money::fromInt(1000));
        $recipeId = $this->getNewRecipeId();
        $this->owner->releaseRecipe($recipeId);

        $events = $this->owner->uncommitedEvents();
        $this->assertCount(1, $events, 'event should be added');
        /**
         * @var RecipeWasReleased $event
         */
        $event = $events[0];
        $this->assertInstanceOf(RecipeWasReleased::class, $event);
        $this->assertInstanceOf(RecipeId::class, $event->recipeId(), 'The recipe id should be defined');

        $recipe = $this->owner->recipeWithId($event->recipeId());

        $this->assertTrue($recipe->isReleased(), 'Recipe should be released');
        $this->assertFalse($recipe->isRetired(), 'Recipe should not be retired');
    }

    /**
     * @depends test_it_should_release_recipe
     */
    public function test_it_should_retire_released_recipe()
    {
        $this->owner->newRecipe(RecipeName::fromString('Recipe name'), Money::fromInt(1000));
        $recipeId = $this->getNewRecipeId();
        $this->owner->releaseRecipe($recipeId);
        $this->owner->uncommitedEvents(); // reset

        $this->owner->retireRecipe($recipeId);

        $events = $this->owner->uncommitedEvents();
        $this->assertCount(1, $events, 'event should be added');
        /**
         * @var RecipeWasRetired $event
         */
        $event = $events[0];
        $this->assertInstanceOf(RecipeWasRetired::class, $event);
        $this->assertInstanceOf(RecipeId::class, $event->recipeId(), 'The recipe id should be defined');

        $recipe = $this->owner->recipeWithId($recipeId);
        $this->assertFalse($recipe->isReleased(), 'Recipe should not be released');
        $this->assertTrue($recipe->isRetired(), 'Recipe should be retired');
    }

    /**
     * @depends test_it_should_retire_released_recipe
     * @depends test_it_should_create_new_recipe
     */
    public function test_it_should_retire_a_pending_recipe()
    {
        $this->owner->newRecipe(RecipeName::fromString('name'), Money::fromInt(1000));
        $recipeId = $this->getNewRecipeId();
        $recipe = $this->owner->recipeWithId($recipeId);

        $this->assertFalse($recipe->isRetired());
        $this->owner->retireRecipe($recipeId);
        $recipe = $this->owner->recipeWithId($recipeId);
        $this->assertTrue($recipe->isRetired());
    }

    /**
     * @expectedException        \Example\Domain\Administration\Exception\RecipeTransitionException
     * @expectedExceptionMessage The recipe transition from Retired to Retired is invalid.
     * @depends test_it_should_retire_released_recipe
     */
    public function test_it_should_throw_exception_when_releasing_a_retired_recipe()
    {
        $this->owner->newRecipe(RecipeName::fromString('name'), Money::fromInt(1000));
        $id = $this->getNewRecipeId();
        $this->owner->releaseRecipe($id);
        $this->owner->retireRecipe($id);
        $this->owner->retireRecipe($id);
    }

    /**
     * @expectedException        \Example\Domain\Common\Exception\EntityNotFoundException
     * @expectedExceptionMessage The entity of type 'Example\Domain\Administration\DomainModel\Recipe' with identity
     */
    public function test_it_should_throw_exception_when_recipe_not_found()
    {
        $this->owner->recipeWithId(new RecipeId(RecipeName::fromString('recipe')));
    }

    /**
     * @return RecipeId
     */
    private function getNewRecipeId()
    {
        $events = $this->owner->uncommitedEvents();
        $this->assertCount(1, $events, 'event should be added');
        /**
         * @var RecipeWasCreated $event
         */
        $event = $events[0];
        $this->assertInstanceOf(RecipeWasCreated::class, $event);

        return $event->recipeId();
    }
}
