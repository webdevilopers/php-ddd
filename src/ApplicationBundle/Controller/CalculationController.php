<?php

namespace Example\ApplicationBundle\Controller;

use Example\Infrastructure\CQRS\Command\CalculationCommand;
use Example\Infrastructure\CQRS\Handler\CalculationHandler;

class CalculationController
{
    /**
     * @var CalculationHandler
     */
    private $handler;

    /**
     * @param CalculationHandler $handler
     */
    public function __construct(CalculationHandler $handler) {
        $this->handler = $handler;
    }

    /**
     * @Route("/calculation/{type}")
     * @Template()
     */
    public function indexAction($type)
    {
        $command = $this->getFormData($type);

        $this->handler->handle($command); // todo would probably be the command bus
        // Get ID from entity and redirect, no return values required
    }

    /**
     * @param string $type
     *
     * @return CalculationCommand
     */
    private function getFormData($type)
    {
        // Form handling generates the configured command object
        $command = new CalculationCommand();
        $command->quantity = 12;
        $command->subTotal = 1000;

        // Form would configure the command with values
        return $command;
    }
}
