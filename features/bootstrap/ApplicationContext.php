<?php

namespace Example;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Example\Domain\Administration\Application\AdministrationService;
use Example\Domain\Administration\Application\HireCandidateCommand;
use Example\Domain\Common\DomainModel\FullName;
use Example\Domain\Administration\DomainModel\Identity\OwnerId;
use Example\Domain\Administration\DomainModel\Owner;
use Example\Domain\Common\DomainModel\JobTitle;
use Example\Domain\Sale\Application\CashierService;
use Example\Domain\Sale\Application\WaitressService;
use Example\Domain\Shipping\Application\CreateDeliveryBoyHandler;
use Example\Infrastructure\InMemory\EmployeeCollection;
use Example\Infrastructure\InMemory\OwnerCollection;
use Example\Infrastructure\Symfony\SymfonyPublisher;
use Example\Domain\Sale\Application\CookService;
use PHPUnit_Framework_Assert as Assert;

/**
 * Defines application features from the specific context.
 */
class ApplicationContext implements Context, SnippetAcceptingContext
{
    /**
     * @var EmployeeCollection
     */
    private $employees;

    /**
     * @var OwnerCollection
     */
    private $owners;

    /**
     * @var AdministrationService
     */
    private $administrationService;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $publisher = new SymfonyPublisher();

        // Administration context
        $this->owners = new OwnerCollection();
        $this->administrationService = new AdministrationService($this->owners, $publisher);

        // Sale context
        $this->employees = new EmployeeCollection();
        new CookService($this->employees, $publisher);
        new CashierService($this->employees, $publisher);
        new WaitressService($this->employees, $publisher);

        // Shipping context
        new CreateDeliveryBoyHandler($this->employees, $publisher);
    }

    /**
     * @Given :name is the store owner
     */
    public function isTheStoreOwner($name)
    {
        $this->owners->saveOwner(
            new Owner(new OwnerId(FullName::fromSingleString($name)), FullName::fromSingleString($name))
        );
    }

    /**
     * @Given :ownerName already employs :employeeName as :role
     */
    public function alreadyEmploysAs($ownerName, $employeeName, $role)
    {
        $this->owners->ownerWithId(new OwnerId(FullName::fromSingleString($ownerName)))
            ->hire(FullName::fromSingleString($employeeName), JobTitle::fromString($role));
    }

    /**
     * @Given :applicantName postulate on a job offering
     */
    public function postulateOnAJobOffering($applicantName)
    {
    }

    /**
     * @When :ownerName hires :applicantName as the new :role
     */
    public function hiresAsTheNew($ownerName, $applicantName, $role)
    {
        $this->administrationService->hireCandidate(
            new HireCandidateCommand(
                new OwnerId(FullName::fromSingleString($ownerName)),
                FullName::fromSingleString($applicantName),
                JobTitle::fromString($role)
            )
        );
    }

    /**
     * @Then :ownerName should have :employeeCount employees
     */
    public function shouldHaveEmployees($ownerName, $employeeCount)
    {
        $owner = $this->owners->ownerWithId(new OwnerId(FullName::fromSingleString($ownerName)));

        Assert::assertAttributeCount((int) $employeeCount, 'candidates', $owner);
    }

    /**
     * @Then There should be :employeeCount employees with :role title
     */
    public function thereShouldBeEmployeesWithTitle($employeeCount, $role)
    {
        Assert::assertCount(
            (int) $employeeCount, $this->employees->employeesWithTitle(JobTitle::fromString($role))
        );
    }
}
