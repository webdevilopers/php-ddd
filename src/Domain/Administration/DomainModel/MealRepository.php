<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Administration\DomainModel;

use Example\Domain\Common\DomainModel\MealName;

interface MealRepository
{
    /**
     * @param MealName $name
     *
     * @return Meal
     */
    public function mealWithName(MealName $name);
}
