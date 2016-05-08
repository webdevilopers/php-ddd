<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Sale\DomainModel;

use Example\Domain\Sale\Exception\PhoneNumberException;

final class PhoneNumberFormatTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param $string
     *
     * @dataProvider provideValidFormat
     */
    public function test_it_should_create_format($string)
    {
        $format = PhoneNumberFormat::fromString($string);
        $this->assertInstanceOf(PhoneNumberFormat::class, $format);
    }

    public static function provideValidFormat()
    {
        return [
            ['CA'],
            ['ca'],
        ];
    }

    /**
     * @param $invalid
     * @param $value
     * @dataProvider provideUnsupportedFormat
     */
    public function test_it_should_throw_exception_when_invalid_format($invalid, $value)
    {
        $this->setExpectedException(
            PhoneNumberException::class, "The phone number format '{$value}' is not a recognized format."
        );

        PhoneNumberFormat::fromString($invalid);
    }

    public static function provideUnsupportedFormat()
    {
        return [
            'Should not support object' => [new \stdClass(), 'Object'],
            'Should not support array' => [[], 'Array'],
            'Should not support empty string' => ['', ''],
        ];
    }

    /**
     * @param $countryCode
     * @param $string
     * @param $expected
     *
     * @dataProvider provideValidConversionNumber
     */
    public function test_should_convert_number_to_correct_format($countryCode, $string, $expected)
    {
        $this->assertSame($expected, PhoneNumberFormat::fromString($countryCode)->convert($string));
    }

    public static function provideValidConversionNumber()
    {
        return [
            ['CA', '1234567', '123-4567'],
        ];
    }
}
