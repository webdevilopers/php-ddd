<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Common\DomainModel;

use Behat\Transliterator\Transliterator;
use Example\Domain\Common\Exception\InvalidArgumentException;

final class JobTitle
{
    /**
     * @var string
     */
    private $title;

    /**
     * @param string $title
     */
    private function __construct($title)
    {
        $this->title = $title;
    }

    /**
     * @param JobTitle $title
     *
     * @return bool
     */
    public function equal(JobTitle $title)
    {
        return $title->title === $this->title;
    }

    /**
     * @return string
     */
    public function title()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @throws InvalidArgumentException
     * @return JobTitle
     */
    public static function fromString($title)
    {
        $title = str_replace('-', '', Transliterator::transliterate($title));
        if (! method_exists(self::class, $title)) {
            throw InvalidArgumentException::invalidJobTitle($title);
        }

        return self::$title();
    }

    /**
     * @return JobTitle
     */
    public static function Cashier()
    {
        return new self('Cashier');
    }

    /**
     * @return JobTitle
     */
    public static function DeliveryBoy()
    {
        return new self('DeliveryBoy');
    }

    /**
     * @return JobTitle
     */
    public static function Waitress()
    {
        return new self('Waitress');
    }

    /**
     * @return JobTitle
     */
    public static function Cook()
    {
        return new self('Cook');
    }

    /**
     * @return JobTitle
     */
    private static function Fake()
    {
        return new self('fake');
    }
}
