<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Administration\DomainModel;

final class RetiredStatus extends RecipeStatus
{
    /**
     * @return bool
     */
    public function isRetired()
    {
        return true;
    }
}
