<?php

namespace Example;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Example\Domain\Administration\Application\AdministrationService;
use Example\Domain\Administration\Application\HireCandidateCommand;
use Example\Domain\Administration\Application\MenuService;
use Example\Domain\Administration\Application\RegisterNewMeal;
use Example\Domain\Administration\Application\ReleaseMeal;
use Example\Domain\Common\DomainModel\FullName;
use Example\Domain\Administration\DomainModel\Identity\OwnerId;
use Example\Domain\Administration\DomainModel\Owner;
use Example\Domain\Common\DomainModel\JobTitle;
use Example\Domain\Common\DomainModel\MealName;
use Example\Domain\Common\DomainModel\Money;
use Example\Domain\Sale\Application\CashierService;
use Example\Domain\Sale\Application\OrderMeal;
use Example\Domain\Sale\Application\OrderService;
use Example\Domain\Sale\Application\WaitressService;
use Example\Domain\Sale\DomainModel\CustomerName;
use Example\Domain\Sale\DomainModel\CustomerType;
use Example\Domain\Sale\DomainModel\Identity\EmployeeId;
use Example\Domain\Sale\DomainModel\Waitress;
use Example\Domain\Shipping\Application\CreateDeliveryBoyHandler;
use Example\Infrastructure\InMemory\EmployeeCollection;
use Example\Infrastructure\InMemory\OwnerCollection;
use Example\Infrastructure\InMemory\Sale\MealCollection;
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
     * @var MealCollection
     */
    private $meals;

    /**
     * @var AdministrationService
     */
    private $administrationService;

    /**
     * @var MenuService
     */
    private $menuService;

    /**
     * @var OrderService
     */
    private $orderService;

    /**
     * The current waitress on post
     *
     * @var Waitress|null
     */
    private $waitress;

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
        $this->meals = new MealCollection();

        // Administration context
        $this->owners = new OwnerCollection();
        $this->administrationService = new AdministrationService($this->owners, $publisher);
        $this->menuService = new MenuService();

        // Sale context
        $this->employees = new EmployeeCollection();
        new CookService($this->employees, $publisher);
        new CashierService($this->employees, $publisher);
        new WaitressService($this->employees, $publisher);
        $this->orderService = new OrderService();

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
     * @Given :owner has created the meal :mealName with price of :mealPrice each
     */
    public function hasCreatedTheMealWithPriceOfEach($owner, $mealName, $mealPrice)
    {
        $this->menuService->registerMeal(
            new RegisterNewMeal(
                new OwnerId(FullName::fromSingleString($owner)),
                MealName::fromString($mealName),
                Money::fromString($mealPrice)
            )
        );
    }

    /**
     * @Given :owner has released the meal :mealName
     */
    public function hasReleasedTheMeal($owner, $mealName)
    {
        $this->menuService->releaseMeal(
            new ReleaseMeal(
                new OwnerId(FullName::fromSingleString($owner)),
                MealName::fromString($mealName)
            )
        );
    }

    /**
     * @Given :applicantName postulate on a job offering
     */
    public function postulateOnAJobOffering($applicantName)
    {
    }

    /**
     * @Given :waitressName is taking phone call orders
     */
    public function isTakingPhoneCallOrders($waitressName)
    {
        $this->waitress = $this->employees->employeeWithIdentity(new EmployeeId($waitressName));
    }

    /**
     * @Given :customerName calls the shop to order the meal :mealName
     */
    public function callsTheShopToOrderTheMeal($customerName, $mealName)
    {
        $meal = $this->meals->mealWithName(MealName::fromString($mealName));

        $this->orderService->orderMeal(
            new OrderMeal(
                $this->waitress->getIdentity(),
                CustomerType::PhoneCustomer(),
                $meal->getIdentity(),
                CustomerName::fromString($customerName)
            )
        );
    }

    /**
     * @Given :customerName phone number is :phoneNumber
     */
    public function phoneNumberIs($customerName, $phoneNumber)
    {
        throw new PendingException();
    }

    /**
     * @Given :customerName home address is :address
     */
    public function homeAddressIs($customerName, $address)
    {
        throw new PendingException();
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
     * @When :waitressName confirms the order with id :orderId at :time
     */
    public function confirmsTheOrderWithIdAt($waitressName, $orderId, $time)
    {
        throw new PendingException();
    }

    /**
     * @When :cookName finishes to cook the order :orderId at :time
     */
    public function finishesToCookTheOrderAt($cookName, $orderId, $time)
    {
        throw new PendingException();
    }

    /**
     * @When :deliveryBoyName delivers the order :orderId at :time
     */
    public function deliversTheOrderAt($deliveryBoyName, $orderId, $time)
    {
        throw new PendingException();
    }

    /**
     * @When :customerName pays :price to :deliveryBoyName
     */
    public function paysTo($customerName, $price, $deliveryBoyName)
    {
        throw new PendingException();
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

    /**
     * @Then Order :orderId should be closed at :time
     */
    public function orderShouldBeClosedAt($orderId, $time)
    {
        throw new PendingException();
    }

    /**
     * @Then The order :orderId should have an income of :money
     */
    public function theOrderShouldHaveAnIncomeOf($orderId, $money)
    {
        throw new PendingException();
    }

    /**
     * @Then The order :orderId should registers a tip of :money
     */
    public function theOrderShouldRegistersATipOf($orderId, $money)
    {
        throw new PendingException();
    }

    /**
     * @Then The order :orderId should have taken :time to complete
     */
    public function theOrderShouldHaveTakenToComplete($orderId, $time)
    {
        throw new PendingException();
    }
}
