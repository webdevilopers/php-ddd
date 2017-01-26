<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Sale\Exception;

final class PhoneNumberException extends \Exception
{
    /**
     * @param string $string
     * @param string $countryCode
     *
     * @return PhoneNumberException
     */
    public static function invalidNumberFormat($string, $countryCode)
    {
        return new self("The phone number '{$string}' is not a valid format for country '{$countryCode}'.");
    }

    /**
     * @param string $string
     *
     * @return PhoneNumberException
     */
    public static function incompatibleFormat($string)
    {
        return new self("The phone number format '{$string}' is not a recognized format.");
    }
}
