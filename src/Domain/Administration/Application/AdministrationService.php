<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Administration\Application;

use Example\Domain\Administration\DomainModel\CandidateRepository;
use Example\Domain\Administration\DomainModel\OwnerRepository;
use Example\Domain\Common\Application\EventPublisher;

final class AdministrationService
{
    /**
     * @var OwnerRepository
     */
    private $ownerRepository;

    /**
     * @var EventPublisher
     */
    private $publisher;

    /**
     * @param OwnerRepository $ownerRepository
     * @param EventPublisher $publisher
     */
    public function __construct(OwnerRepository $ownerRepository, EventPublisher $publisher)
    {
        $this->ownerRepository = $ownerRepository;
        $this->publisher = $publisher;
    }

    /**
     * @param HireCandidateCommand $command
     */
    public function hireCandidate(HireCandidateCommand $command)
    {
        $owner = $this->ownerRepository->ownerWithId($command->hiredBy());
        $owner->hire($command->candidateName(), $command->title());

        $this->ownerRepository->saveOwner($owner);

        $this->publisher->publish($owner->uncommitedEvents());
    }
}
