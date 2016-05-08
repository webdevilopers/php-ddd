<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Administration\DomainModel;

use Example\Domain\Administration\Exception\RecipeTransitionException;

/**
 * State workflow for recipes.
 */
abstract class RecipeStatus
{
    /**
     * @return bool
     */
    public function isReleased()
    {
        return false;
    }

    /**
     * @return bool
     */
    public function isRetired()
    {
        return false;
    }

    /**
     * @return bool
     */
    public function isPending()
    {
        return false;
    }

    public function release(RecipeContext $recipe)
    {
        throw RecipeTransitionException::invalidRecipeTransition($this, new ReleasedStatus());
    }

    public function retire(RecipeContext $recipe)
    {
        throw RecipeTransitionException::invalidRecipeTransition($this, new RetiredStatus());
    }

    /**
     * @return string
     */
    public function toString()
    {
        return str_ireplace([__NAMESPACE__, '\\', 'Status'], '', get_class($this));
    }

    /**
     * @param string $string
     *
     * @return RecipeStatus
     */
    public static function fromString($string)
    {
        return self::$string();
    }

    private static function Pending()
    {
        return new PendingStatus();
    }

    private static function Released()
    {
        return new ReleasedStatus();
    }

    private static function Retired()
    {
        return new RetiredStatus();
    }
}
