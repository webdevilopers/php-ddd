<?php

namespace Example;

use Example\Infrastructure\CQRS\Command\CalculationCommand;
use Example\Infrastructure\CQRS\Handler\CalculationHandler;
use Example\Domain\Model\DormerCalculation;
use Example\Domain\Model\DormerCalculationPrice;
use Example\ApplicationBundle\Controller\CalculationController;
use Example\Infrastructure\Doctrine\DoctrineDormerCalculationRepository;
use Example\Infrastructure\UniqueIdGenerator;

final class WorkflowTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_should_do_something()
    {
        $repository = new DoctrineDormerCalculationRepository();
        $controller = new CalculationController(
            new CalculationHandler(
                $repository,
                new UniqueIdGenerator()
            )
        );
        $controller->indexAction(CalculationCommand::BASIC_TYPE);

        /**
         * @var DormerCalculation $createdEntity
         */
        $createdEntity = $repository->find('uniqueid');

        $this->assertInstanceOf(DormerCalculation::class, $createdEntity);
        $this->assertAttributeCount(1, 'prices', $createdEntity);
        $this->assertAttributeContainsOnly(DormerCalculationPrice::class, 'prices', $createdEntity);
        $this->assertSame(12000, $createdEntity->getTotal());
    }
}
