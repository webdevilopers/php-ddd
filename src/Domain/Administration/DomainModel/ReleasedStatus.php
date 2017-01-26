<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Administration\DomainModel;

final class ReleasedStatus extends RecipeStatus
{
    /**
     * @return bool
     */
    public function isReleased()
    {
        return true;
    }

    /**
     * @param RecipeContext $recipe
     */
    public function retire(RecipeContext $recipe)
    {
        $recipe->setState(new RetiredStatus());
    }
}
