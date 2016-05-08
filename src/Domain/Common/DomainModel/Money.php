<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Common\DomainModel;

final class Money
{
    /**
     * @var int
     */
    private $amount;

    /**
     * @param int $amount
     */
    private function __construct($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return int
     */
    public function amount()
    {
        return $this->amount;
    }

    /**
     * @param int $int
     *
     * @return Money
     */
    public static function fromInt($int)
    {
        return new self($int);
    }
}
