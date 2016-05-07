<?php

namespace Example\Domain\Administration\DomainModel;

use Example\Domain\Administration\DomainModel\Identity\OwnerId;
use Example\Domain\Administration\DomainModel\Event\CandidateWasHired;
use Example\Domain\Common\DomainModel\AggregateRoot;
use Example\Domain\Common\DomainModel\FullName;
use Example\Domain\Common\DomainModel\JobTitle;

final class Owner extends AggregateRoot
{
    /**
     * @var OwnerId
     */
    private $identity;

    /**
     * @var Candidate[]
     */
    private $candidates = [];

    /**
     * @param OwnerId $id
     */
    public function __construct(OwnerId $id)
    {
        $this->identity = $id;
    }

    /**
     * @return OwnerId
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     * @param FullName $name
     * @param JobTitle $title
     */
    public function hire(FullName $name, JobTitle $title)
    {
        $this->mutate(new CandidateWasHired($this->identity, $name, $title));
    }

    /**
     * @param CandidateWasHired $event
     */
    protected function onCandidateWasHired(CandidateWasHired $event)
    {
        $this->candidates[] = new Candidate($event->candidateName(), $event->title());
    }

    /**
     * @param string $id
     *
     * @return Owner
     */
    public static function fakeWithId($id)
    {
        return new self(new OwnerId(FullName::fromSingleString($id)));
    }
}
