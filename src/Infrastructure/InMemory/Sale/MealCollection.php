<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Infrastructure\InMemory\Sale;

use Example\Domain\Common\Exception\EntityNotFoundException;
use Example\Domain\Sale\DomainModel\Identity\MealId;
use Example\Domain\Sale\DomainModel\Meal;
use Example\Domain\Sale\DomainModel\MealRepository;

final class MealCollection implements MealRepository
{
    /**
     * @var Meal[]
     */
    private $meals = [];

    /**
     * @param Meal $meal
     */
    public function saveMeal(Meal $meal)
    {
        $this->meals[$meal->getIdentity()->id()] = $meal;
    }

    /**
     * @param MealId $id
     *
     * @return Meal
     * @throws EntityNotFoundException
     */
    public function activeMeal(MealId $id)
    {
        if (! isset($this->meals[$id->id()])) {
            throw EntityNotFoundException::entityWithIdentity($id);
        }

        return $this->meals[$id->id()];
    }
}
