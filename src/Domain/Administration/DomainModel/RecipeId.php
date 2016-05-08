<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Administration\DomainModel;

use Behat\Transliterator\Transliterator;
use Example\Domain\Common\DomainModel\Identity\Identity;

final class RecipeId implements Identity
{
    /**
     * @var RecipeName
     */
    private $name;

    /**
     * @param RecipeName $name
     */
    public function __construct(RecipeName $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEntityClass()
    {
        return Recipe::class;
    }

    /**
     * @return mixed
     */
    public function id()
    {
        return Transliterator::transliterate($this->name->toString());
    }
}
