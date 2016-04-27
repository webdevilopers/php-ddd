<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Administration\DomainModel\Identity;

use Example\Domain\Administration\DomainModel\Owner;
use Example\Domain\Common\DomainModel\FullName;
use Example\Domain\Common\DomainModel\Identity\Identity;

final class OwnerId implements Identity
{
    /**
     * @var FullName
     */
    private $name;

    /**
     * @param FullName $name
     */
    public function __construct(FullName $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEntityClass()
    {
        return Owner::class;
    }

    /**
     * @return mixed
     */
    public function id()
    {
        return $this->name->toString();
    }
}
