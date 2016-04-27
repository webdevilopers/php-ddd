<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Administration\DomainModel;

use Example\Domain\Administration\DomainModel\Identity\OwnerId;

interface OwnerRepository
{
    /**
     * @param OwnerId $ownerId
     *
     * @return Owner
     */
    public function ownerWithId(OwnerId $ownerId);

    /**
     * @param Owner $owner
     */
    public function saveOwner(Owner $owner);
}
