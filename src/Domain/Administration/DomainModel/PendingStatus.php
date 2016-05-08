<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Administration\DomainModel;

final class PendingStatus extends RecipeStatus
{
    public function release(RecipeContext $recipe)
    {
        $recipe->setState(new ReleasedStatus());
    }

    public function retire(RecipeContext $recipe)
    {
        $recipe->setState(new RetiredStatus());
    }
}
