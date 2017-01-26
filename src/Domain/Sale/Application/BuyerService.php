<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Sale\Application;

use Example\Domain\Sale\DomainModel\Address;
use Example\Domain\Sale\DomainModel\Buyer;
use Example\Domain\Sale\DomainModel\BuyerRepository;
use Example\Domain\Sale\DomainModel\PhoneBuyer;
use Example\Domain\Sale\DomainModel\PhoneNumber;

final class BuyerService
{
    /**
     * @var BuyerRepository
     */
    private $buyers;

    /**
     * @var string
     */
    private $countryCode;

    /**
     * @param BuyerRepository $buyers
     * @param string $countryCode
     */
    public function __construct(BuyerRepository $buyers, $countryCode)
    {
        $this->buyers = $buyers;
        $this->countryCode = $countryCode;
    }

    /**
     * @param string $phoneNumber
     * @param string $address
     */
    public function registerPhoneBuyer($phoneNumber, $address)
    {
        $buyer = new PhoneBuyer(
            PhoneNumber::fromString($phoneNumber, $this->countryCode),
            Address::fromString($address)
        );

        $this->buyers->saveBuyer($buyer);
    }
}
