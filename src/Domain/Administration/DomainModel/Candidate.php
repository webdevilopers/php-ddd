<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Administration\DomainModel;

use Example\Domain\Administration\DomainModel\Identity\AdministrationIdGenerator;
use Example\Domain\Common\DomainModel\FullName;
use Example\Domain\Common\DomainModel\JobTitle;

/**
 * Entity part of the Owner aggregate root
 */
final class Candidate
{
    /**
     * @var FullName
     */
    private $name;

    /**
     * @var JobTitle
     */
    private $title;

    /**
     * @param FullName $name
     * @param JobTitle $title
     */
    public function __construct(FullName $name, JobTitle $title)
    {
        $this->name = $name;
        $this->title = $title;
    }
}
