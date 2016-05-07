<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Sale\Application;

use Example\Domain\Administration\DomainModel\Event\CandidateWasHired;
use Example\Domain\Common\Application\EventPublisher;
use Example\Domain\Common\DomainModel\JobTitle;
use Example\Domain\Sale\DomainModel\Cashier;
use Example\Domain\Sale\DomainModel\EmployeeRepository;
use Example\Domain\Sale\DomainModel\Identity\EmployeeId;

final class CashierService
{
    /**
     * @var EmployeeRepository
     */
    private $employeeRepository;

    /**
     * @var EventPublisher
     */
    private $publisher;

    /**
     * @param EmployeeRepository $employeeRepository
     * @param EventPublisher $publisher
     */
    public function __construct(EmployeeRepository $employeeRepository, EventPublisher $publisher)
    {
        $this->employeeRepository = $employeeRepository;
        $publisher->addListener(CandidateWasHired::class, $this, 'onCandidateWasHired');
        $this->publisher = $publisher;
    }

    /**
     * @param CandidateWasHired $event
     */
    public function onCandidateWasHired(CandidateWasHired $event)
    {
        if (! $event->title()->equal(JobTitle::Cashier())) {
            return;
        }

        $cashier = new Cashier(EmployeeId::fromName($event->candidateName()), $event->candidateName());

        $this->employeeRepository->saveEmployee($cashier);
        $this->publisher->publish($cashier->uncommitedEvents());
    }
}
