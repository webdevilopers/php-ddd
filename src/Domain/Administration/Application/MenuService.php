<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Administration\Application;

use Example\Domain\Administration\DomainModel\OwnerRepository;
use Example\Domain\Common\Application\EventPublisher;

/**
 * All in one class service
 */
final class MenuService
{
    /**
     * @var OwnerRepository
     */
    private $owners;

    /**
     * @var EventPublisher
     */
    private $publisher;

    /**
     * @param OwnerRepository $owners
     * @param EventPublisher $publisher
     */
    public function __construct(OwnerRepository $owners, EventPublisher $publisher)
    {
        $this->owners = $owners;
        $this->publisher = $publisher;
    }

    /**
     * @param RegisterNewRecipe $command
     */
    public function registerRecipe(RegisterNewRecipe $command)
    {
        $owner = $this->owners->ownerWithId($command->creator());
        $owner->newRecipe($command->name(), $command->price());

        $this->owners->saveOwner($owner);

        $this->publisher->publish($owner->uncommitedEvents());
    }

    /**
     * @param ReleaseRecipe $command
     */
    public function releaseRecipe(ReleaseRecipe $command)
    {
        $owner = $this->owners->ownerWithId($command->creator());
        $owner->releaseRecipe($command->recipeId());

        $this->owners->saveOwner($owner);

        $this->publisher->publish($owner->uncommitedEvents());
    }
}
