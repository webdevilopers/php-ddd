<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Infrastructure\InMemory;

use Example\Domain\Administration\DomainModel\Identity\OwnerId;
use Example\Domain\Administration\DomainModel\Owner;
use Example\Domain\Common\DomainModel\FullName;

final class OwnerCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var OwnerCollection
     */
    private $collection;

    public function setUp()
    {
        $this->collection = new OwnerCollection();
    }

    public function test_it_should_return_owner_with_id()
    {
        $owner = new Owner(new OwnerId(FullName::fromSingleString('id')));
        $this->collection->saveOwner($owner);

        $this->assertCount(1, $this->collection);
        $this->assertSame($owner, $this->collection->ownerWithId($owner->getIdentity()));
    }

    /**
     * @expectedException        \Example\Domain\Common\Exception\EntityNotFoundException
     * @expectedExceptionMessage The entity of type 'Example\Domain\Administration\DomainModel\Owner' with identity '[FullNa
     */
    public function test_it_should_throw_exception_when_owner_not_found()
    {
        $this->assertCount(0, $this->collection);
        $this->collection->ownerWithId(new OwnerId(FullName::fromSingleString('invalid')));
    }
}
