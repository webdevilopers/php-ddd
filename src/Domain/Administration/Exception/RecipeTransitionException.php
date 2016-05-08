<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Administration\Exception;

use Example\Domain\Administration\DomainModel\RecipeStatus;

final class RecipeTransitionException extends \Exception
{
    /**
     * @param RecipeStatus $from
     * @param RecipeStatus $to
     *
     * @return RecipeTransitionException
     */
    public static function invalidRecipeTransition(RecipeStatus $from, RecipeStatus $to)
    {
        return new self("The recipe transition from {$from->toString()} to {$to->toString()} is invalid.");
    }
}
