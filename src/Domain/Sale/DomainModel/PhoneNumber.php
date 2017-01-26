<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Sale\DomainModel;

use Example\Domain\Sale\Exception\PhoneNumberException;

final class PhoneNumber
{
    /**
     * @var string
     */
    private $number;

    /**
     * @var PhoneNumberFormat
     */
    private $format;

    /**
     * @param string $number
     * @param PhoneNumberFormat $format
     */
    private function __construct($number, PhoneNumberFormat $format)
    {
        $this->number = $number;
        $this->format = $format;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->format->convert($this->number);
    }

    /**
     * @return string
     */
    public function countryCode()
    {
        return $this->format->countryCode();
    }

    /**
     * @param string $number
     * @param string $countryCode
     *
     * @throws \Example\Domain\Sale\Exception\PhoneNumberException
     * @return PhoneNumber
     */
    public static function fromString($number, $countryCode)
    {
        $format = PhoneNumberFormat::fromString($countryCode);
        if (! $format->validate($number)) {
            throw PhoneNumberException::invalidNumberFormat($number, $countryCode);
        }

        return new self($number, $format);
    }
}
