<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Administration\DomainModel;

use Example\Domain\Administration\DomainModel\Event\CandidateWasHired;
use Example\Domain\Administration\DomainModel\Identity\OwnerId;
use Example\Domain\Common\DomainModel\FullName;
use Example\Domain\Common\DomainModel\JobTitle;

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
    public function test_it_should_create_new_recipe_with_ingredients()
    {
        $this->markTestIncomplete('TODO');
        $recipe = $owner->newRecipe(new RecipeId(), RecipeName::fromString('All dress Pizza'), $ingredients = []);

        $this->assertInstanceOf(Recipe::class, $recipe, 'Owner should create recipe');
        $this->assertFalse($recipe->isReleased(), 'Recipe should not be released by default');
        $this->assertFalse($recipe->isRetired(), 'Recipe should not be retired by default');
    }

    /**
     * @depends test_it_should_create_new_recipe_with_ingredients
     */
    public function test_it_should_release_recipe()
    {
        $this->markTestIncomplete('TODO');
        $recipe = $owner->releaseRecipe(new RecipeId());
        $this->assertTrue($recipe->isReleased(), 'Recipe should be released');
        $this->assertFalse($recipe->isRetired(), 'Recipe should not be retired');
    }

    /**
     * @depends test_it_should_release_recipe
     */
    public function test_it_should_retire_released_recipe()
    {
        $this->markTestIncomplete('TODO');
        $recipe = $owner->retireRecipe(new RecipeId());
        $this->assertFalse($recipe->isReleased(), 'Recipe should not be released');
        $this->assertTrue($recipe->isRetired(), 'Recipe should be retired');
    }
}
