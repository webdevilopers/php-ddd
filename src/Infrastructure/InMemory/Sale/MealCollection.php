<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Infrastructure\InMemory\Sale;

use Example\Domain\Administration\DomainModel\Meal;
use Example\Domain\Administration\DomainModel\MealRepository;
use Example\Domain\Common\DomainModel\MealName;

final class MealCollection implements MealRepository
{
    /**
     * @param MealName $name
     *
     * @return Meal
     */
    public function mealWithName(MealName $name)
    {
        throw new \RuntimeException('Method ' . __METHOD__ . ' not implemented yet.');
    }
}
