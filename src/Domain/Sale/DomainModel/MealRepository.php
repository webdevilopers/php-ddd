<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Sale\DomainModel;

use Example\Domain\Common\Exception\EntityNotFoundException;
use Example\Domain\Sale\DomainModel\Identity\MealId;

interface MealRepository
{
    /**
     * @param Meal $meal
     */
    public function saveMeal(Meal $meal);

    /**
     * @param MealId $id
     *
     * @return Meal
     * @throws EntityNotFoundException
     */
    public function activeMeal(MealId $id);
}
