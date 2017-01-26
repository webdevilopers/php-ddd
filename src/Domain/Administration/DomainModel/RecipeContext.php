<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Administration\DomainModel;

interface RecipeContext
{
    /**
     * @param RecipeStatus $status
     *
     * @internal Used by state machine only
     */
    public function setState(RecipeStatus $status);
}
