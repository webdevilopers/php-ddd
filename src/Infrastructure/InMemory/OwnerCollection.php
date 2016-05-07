<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Infrastructure\InMemory;

use Example\Domain\Administration\DomainModel\Identity\OwnerId;
use Example\Domain\Administration\DomainModel\Owner;
use Example\Domain\Administration\DomainModel\OwnerRepository;
use Example\Domain\Common\Exception\EntityNotFoundException;

final class OwnerCollection implements OwnerRepository, \Countable
{
    /**
     * @var Owner[]
     */
    private $owners = [];

    /**
     * @param OwnerId $ownerId
     *
     * @throws EntityNotFoundException
     * @return Owner
     */
    public function ownerWithId(OwnerId $ownerId)
    {
        if (! isset($this->owners[$ownerId->id()])) {
            throw EntityNotFoundException::entityWithIdentity($ownerId);
        }

        return $this->owners[$ownerId->id()];
    }

    /**
     * @param Owner $owner
     */
    public function saveOwner(Owner $owner)
    {
        $this->owners[$owner->getIdentity()->id()] = $owner;
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->owners);
    }
}
