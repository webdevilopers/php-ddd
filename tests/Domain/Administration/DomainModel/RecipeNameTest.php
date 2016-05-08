<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Administration\DomainModel;

final class RecipeNameTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_should_return_string_representation()
    {
        $this->assertSame('my name', RecipeName::fromString('my name')->toString());
    }

    /**
     * @expectedException        \Example\Domain\Common\Exception\InvalidArgumentException
     * @expectedExceptionMessage The recipe name cannot be empty.
     */
    public function test_it_should_not_allow_empty_string()
    {
        RecipeName::fromString('');
    }
}
