<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Administration\DomainModel\Event;

use Example\Domain\Common\DomainModel\Event\DomainEvent;
use Example\Domain\Common\DomainModel\FullName;
use Example\Domain\Administration\DomainModel\Identity\OwnerId;
use Example\Domain\Common\DomainModel\JobTitle;

final class CandidateWasHired implements DomainEvent
{
    /**
     * @var OwnerId
     */
    private $hiredBy;

    /**
     * @var FullName
     */
    private $candidateName;

    /**
     * @var JobTitle
     */
    private $title;

    /**
     * @param OwnerId $hiredBy
     * @param FullName $name
     * @param JobTitle $title
     */
    public function __construct(OwnerId $hiredBy, FullName $name, JobTitle $title)
    {
        $this->hiredBy = $hiredBy;
        $this->candidateName = $name;
        $this->title = $title;
    }

    /**
     * @return FullName
     */
    public function candidateName()
    {
        return $this->candidateName;
    }

    /**
     * @return OwnerId
     */
    public function hiredBy()
    {
        return $this->hiredBy;
    }

    /**
     * @return JobTitle
     */
    public function title()
    {
        return $this->title;
    }
}
