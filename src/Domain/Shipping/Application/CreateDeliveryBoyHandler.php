<?php
/**
 * This file is part of the php-ddd project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Example\Domain\Shipping\Application;

use Example\Domain\Administration\DomainModel\Event\CandidateWasHired;
use Example\Domain\Common\Application\DomainCommand;
use Example\Domain\Common\Application\EventPublisher;
use Example\Domain\Common\DomainModel\JobTitle;
use Example\Domain\Common\Exception\CommandHandlerException;
use Example\Domain\Shipping\DomainModel\DeliveryBoy;
use Example\Domain\Shipping\DomainModel\DeliveryBoyRepository;
use Example\Domain\Shipping\DomainModel\Identity\DeliveryBoyId;

final class CreateDeliveryBoyHandler
{
    /**
     * @var DeliveryBoyRepository
     */
    private $repository;

    /**
     * @var EventPublisher
     */
    private $publisher;

    /**
     * @param DeliveryBoyRepository $repository
     * @param EventPublisher $publisher
     */
    public function __construct(DeliveryBoyRepository $repository, EventPublisher $publisher)
    {
        $this->repository = $repository;
        $publisher->addListener(CandidateWasHired::class, $this, 'onCandidateWasHired');
        $this->publisher = $publisher;
    }

    /**
     * @param DomainCommand $command
     * @throws \Example\Domain\Common\Exception\CommandHandlerException
     */
    public function handle(DomainCommand $command)
    {
        if (! $command instanceof CreateDeliveryBoyCommand) {
            throw CommandHandlerException::unsupportedCommandException($command, $this);
        }

        $deliveryBoy = new DeliveryBoy(new DeliveryBoyId($command->name()));
        $this->repository->saveDeliveryBoy($deliveryBoy);
    }

    /**
     * @param CandidateWasHired $event
     */
    public function onCandidateWasHired(CandidateWasHired $event)
    {
        if (! $event->title()->equal(JobTitle::DeliveryBoy())) {
            return;
        }

        $this->handle(
            new CreateDeliveryBoyCommand($event->candidateName())
        );
    }
}
