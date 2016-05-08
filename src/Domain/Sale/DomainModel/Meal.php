<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Sale\DomainModel;

use Example\Domain\Common\DomainModel\AggregateRoot;
use Example\Domain\Sale\DomainModel\Identity\MealId;

final class Meal extends AggregateRoot
{
    /**
     * @var mixed
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @param MealId $id
     * @param string $name
     */
    public function __construct(MealId $id, $name)
    {
        $this->id = $id->id();
        $this->name = $name;
    }

    /**
     * @return MealId
     */
    public function getIdentity()
    {
        return new MealId($this->id);
    }
}
