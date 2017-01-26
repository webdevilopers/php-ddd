<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Sale\DomainModel;

final class BuyerTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_should_be_created_from_phone()
    {
        $buyer = new PhoneBuyer(
            PhoneNumber::fromString('5555555', 'CA'),
            Address::fromString('1 main street')
        );

        $this->assertInstanceOf(BuyerId::class, $buyer->getIdentity());
        $this->assertSame('555-5555', $buyer->getIdentity()->id());
        $this->assertSame(Buyer::class, $buyer->getIdentity()->getEntityClass());
    }
}
