<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Sale\DomainModel;

use Example\Domain\Sale\Exception\PhoneNumberException;

final class PhoneNumberFormat
{
    private static $mappings = [
        'CA' => 'REGEX', // todo add regex
    ];

    /**
     * @var string
     */
    private $countryCode;

    /**
     * @param string $countryCode
     */
    private function __construct($countryCode)
    {
        $this->countryCode = $countryCode;
    }

    /**
     * @return string
     */
    public function countryCode()
    {
        return $this->countryCode;
    }

    /**
     * @param string $number
     *
     * @return string
     */
    public function convert($number)
    {
        $number = str_ireplace('-', '', $number);

        // todo implement country base conversion per class
        return substr_replace($number, '-', 3, 0);
    }

    /**
     * @param string $number
     *
     * @return bool
     */
    public function validate($number)
    {
        $length = 7;
        if (strpos($number, '-')) {
            $length = 8;
        }

        return strlen($number) === $length;
    }

    /**
     * @param string $string
     *
     * @throws \Example\Domain\Sale\Exception\PhoneNumberException
     * @return PhoneNumberFormat
     */
    public static function fromString($string)
    {
        if (is_object($string)) {
            $string = 'Object';
        }

        if (is_array($string)) {
            $string = 'Array';
        }

        $countryCode = strtoupper($string);
        if (! isset(self::$mappings[$countryCode])) {
            throw PhoneNumberException::incompatibleFormat($string);
        }

        return new self($countryCode);
    }
}
