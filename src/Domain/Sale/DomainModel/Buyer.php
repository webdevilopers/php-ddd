<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Sale\DomainModel;

final class Buyer
{
    /**
     * @var string
     */
    private $phone_number;

    /**
     * @var string
     */
    private $phone_country;

    /**
     * @var string
     */
    private $address;

    /**
     * @param PhoneNumber $number
     * @param Address $address
     */
    private function __construct(PhoneNumber $number, Address $address)
    {
        $this->phone_number = $number->toString();
        $this->phone_country = $number->countryCode();
        $this->address = $address;
    }

    /**
     * @return BuyerId
     */
    public function getIdentity()
    {
        return BuyerId::phoneBuyer(PhoneNumber::fromString($this->phone_number, $this->phone_country));
    }

    /**
     * @param PhoneNumber $number
     * @param Address $address
     *
     * @return Buyer
     */
    public static function PhoneBuyer(PhoneNumber $number, Address $address)
    {
        return new self($number, $address);
    }
}
