<?php

namespace Example\Infrastructure\CQRS\Handler;

use Example\Domain\DormerIdentityGenerator;
use Example\Domain\Model\DormerCalculation;
use Example\Domain\Repository\DormerCalculationRepository;
use Example\Infrastructure\CQRS\Command\CalculationCommand;

class CalculationHandler
{
    /**
     * @var DormerCalculationRepository
     */
    private $repository;

    /**
     * @var DormerIdentityGenerator
     */
    private $generator;

    /**
     * @param DormerCalculationRepository $repository
     * @param DormerIdentityGenerator $generator
     */
    public function __construct(DormerCalculationRepository $repository, DormerIdentityGenerator $generator)
    {
        $this->repository = $repository;
        $this->generator = $generator;
    }

    /**
     * @param CalculationCommand $command
     */
    public function handle($command)
    {
        $entity = new DormerCalculation($this->generator->generateDormerIdentity());
        $entity->addPrice('total', $command->subTotal, $command->quantity);

        $this->repository->saveCalculation($entity);
    }
}
