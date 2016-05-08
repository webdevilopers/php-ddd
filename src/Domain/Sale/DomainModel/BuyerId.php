<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Sale\DomainModel;

use Example\Domain\Common\DomainModel\Identity\Identity;

final class BuyerId implements Identity
{
    /**
     * @var string
     */
    private $id;

    /**
     * @param string $number
     */
    private function __construct($number)
    {
        $this->id = $number;
    }

    /**
     * @return string
     */
    public function getEntityClass()
    {
        return Buyer::class;
    }

    /**
     * @return mixed
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @param string $string
     *
     * @return BuyerId
     */
    public static function fromString($string)
    {
        return new self($string);
    }

    /**
     * @param PhoneNumber $number
     *
     * @return BuyerId
     */
    public static function phoneBuyer(PhoneNumber $number)
    {
        return new self($number->toString());
    }
}
