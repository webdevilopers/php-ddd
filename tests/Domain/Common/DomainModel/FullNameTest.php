<?php

namespace Example\Domain\Common\DomainModel;

final class FullNameTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_should_be_created_from_string()
    {
        $name = FullName::fromString('first', 'last');
        $this->assertInstanceOf(FullName::class, $name);
        $this->assertSame('first', $name->firstName());
        $this->assertSame('last', $name->lastName());
    }

    public function test_it_should_be_converted_to_string()
    {
        $this->assertSame('[FullName] First Last', FullName::fromString('First', 'Last')->toString());
    }

    public function test_it_should_be_create_from_single_string()
    {
        $name = FullName::fromSingleString('name');
        $this->assertInstanceOf(FullName::class, $name);
        $this->assertSame('Mr/Miss', $name->firstName());
        $this->assertSame('name', $name->lastName());
    }

    public function test_it_should_return_equality()
    {
        $lowerJohnDoe = FullName::fromString('john', 'doe');
        $upperJohnDoe = FullName::fromString('John', 'Doe');
        $janeDoe = FullName::fromString('Jane', 'Doe');

        $this->assertTrue($lowerJohnDoe->equal($lowerJohnDoe));
        $this->assertFalse($lowerJohnDoe->equal($upperJohnDoe));
        $this->assertFalse($lowerJohnDoe->equal($janeDoe));
    }
}
