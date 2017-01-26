<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Sale\DomainModel;

use Example\Domain\Sale\Exception\PhoneNumberException;

final class PhoneNumberTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_should_be_created_without_slashes()
    {
        $number = PhoneNumber::fromString('1234567', 'CA');
        $this->assertSame('123-4567', $number->toString());
    }

    public function test_it_should_be_created_with_slashes()
    {
        $number = PhoneNumber::fromString('123-4567', 'CA');
        $this->assertSame('123-4567', $number->toString());
    }

    /**
     * @param $invalid
     * @dataProvider provideInvalidFormat
     */
    public function test_it_should_throw_exception_when_invalid_format($invalid)
    {
        $this->setExpectedException(
            PhoneNumberException::class,
            "The phone number '{$invalid}' is not a valid format for country 'CA'."
        );
        PhoneNumber::fromString($invalid, 'CA');
    }

    public static function provideInvalidFormat()
    {
        return [
            'Should not contain alphabetic char' => ['e2121'],
        ];
    }
}
