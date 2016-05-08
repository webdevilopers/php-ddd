<?php

namespace Example;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Transliterator\Transliterator;
use Example\Domain\Administration\Application\AdministrationService;
use Example\Domain\Administration\Application\HireCandidateCommand;
use Example\Domain\Administration\Application\MenuService;
use Example\Domain\Administration\Application\RegisterNewRecipe;
use Example\Domain\Administration\Application\ReleaseRecipe;
use Example\Domain\Administration\DomainModel\RecipeId;
use Example\Domain\Administration\DomainModel\RecipeName;
use Example\Domain\Common\DomainModel\FullName;
use Example\Domain\Administration\DomainModel\Identity\OwnerId;
use Example\Domain\Administration\DomainModel\Owner;
use Example\Domain\Common\DomainModel\JobTitle;
use Example\Domain\Common\DomainModel\Money;
use Example\Domain\Sale\Application\BuyerService;
use Example\Domain\Sale\Application\CashierService;
use Example\Domain\Sale\Application\CreateMealOnRecipeCreated;
use Example\Domain\Sale\Application\OrderService;
use Example\Domain\Sale\Application\WaitressService;
use Example\Domain\Sale\DomainModel\BuyerId;
use Example\Domain\Sale\DomainModel\BuyerRepository;
use Example\Domain\Sale\DomainModel\CustomerType;
use Example\Domain\Sale\DomainModel\Identity\EmployeeId;
use Example\Domain\Sale\DomainModel\Identity\MealId;
use Example\Domain\Sale\DomainModel\Identity\OrderId;
use Example\Domain\Sale\DomainModel\PhoneNumber;
use Example\Domain\Shipping\Application\CreateDeliveryBoyHandler;
use Example\Infrastructure\ForgedIdGenerator;
use Example\Infrastructure\InMemory\EmployeeCollection;
use Example\Infrastructure\InMemory\OwnerCollection;
use Example\Infrastructure\InMemory\Sale\BuyerCollection;
use Example\Infrastructure\InMemory\Sale\MealCollection;
use Example\Infrastructure\InMemory\Sale\OrderCollection;
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
     * @var BuyerRepository
     */
    private $buyers;

    /**
     * @var PhoneNumber[]
     */
    private $phones = [];

    /**
     * @var AdministrationService
     */
    private $administrationService;

    /**
     * @var MenuService
     */
    private $menu;

    /**
     * @var BuyerService
     */
    private $buyerService;

    /**
     * @var OrderService
     */
    private $orderService;

    /**
     * @var OrderCollection
     */
    private $orders;

    /**
     * @var MealCollection
     */
    private $meals;

    /**
     * @var ForgedIdGenerator
     */
    private $fakeIdGenerator;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        // Infrastructure
        $publisher = new SymfonyPublisher();
        $this->buyers = new BuyerCollection();
        $this->owners = new OwnerCollection();
        $this->employees = new EmployeeCollection();
        $this->fakeIdGenerator = new ForgedIdGenerator();
        $this->orders = new OrderCollection();
        $this->meals = new MealCollection();

        // Administration context
        $this->administrationService = new AdministrationService($this->owners, $publisher);
        $this->menu = new MenuService($this->owners, $publisher);

        // Sale context
        new CookService($this->employees, $publisher);
        new CashierService($this->employees, $publisher);
        $this->buyerService = new BuyerService($this->buyers, 'CA'); // default country
        new WaitressService($this->employees, $publisher);
        $this->orderService = new OrderService(
            $this->orders, $publisher, $this->buyers, $this->meals, $this->fakeIdGenerator
        );
        new CreateMealOnRecipeCreated($this->meals, $publisher);

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
        $this->administrationService->hireCandidate(
            new HireCandidateCommand(
                new OwnerId(FullName::fromSingleString($ownerName)),
                FullName::fromSingleString($employeeName),
                JobTitle::fromString($role)
            )
        );
    }

    /**
     * @Given :owner has created the recipe :recipeName with price of :recipePrice each
     */
    public function hasCreatedTheRecipeWithPriceOfEach($owner, $recipeName, $recipePrice)
    {
        $this->menu->registerRecipe(
            new RegisterNewRecipe(
                new OwnerId(FullName::fromSingleString($owner)),
                RecipeName::fromString($recipeName),
                Money::fromInt($recipePrice)
            )
        );
    }

    /**
     * @Given :owner has released the recipe :recipeName
     */
    public function hasReleasedTheRecipe($owner, $recipeName)
    {
        $this->menu->releaseRecipe(
            new ReleaseRecipe(
                new OwnerId(FullName::fromSingleString($owner)),
                new RecipeId(RecipeName::fromString($recipeName))
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
     * @Given :customerName never ordered meals to the shop
     */
    public function neverOrderedMealsToTheShop($customerName)
    {
    }

    /**
     * @Given :customerName gives his phone number :phoneNumber and home address :address
     */
    public function givesHisPhoneNumberAndHomeAddress($customerName, $phoneNumber, $address)
    {
        $this->phones[$customerName] = PhoneNumber::fromString($phoneNumber, 'CA');
        $this->buyerService->registerPhoneBuyer($phoneNumber, $address);
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
     * @When :waitressName starts the order :orderId of :customerName
     */
    public function startsTheOrderOf($waitressName, $orderId, $customerName)
    {
        $this->fakeIdGenerator->returnsOrderIdOnNextCall(new OrderId($orderId));
        $this->orderService->startOrder(
            EmployeeId::fromName(FullName::fromSingleString($waitressName)),
            CustomerType::PhoneCustomer(),
            BuyerId::phoneBuyer($this->getPhoneNumberOfCustomer($customerName))
        );
    }

    /**
     * @When :customerName order :quantity meal :mealName on order :orderId
     */
    public function orderMealOnOrder($customerName, $quantity, $mealName, $orderId)
    {
        $this->orderService->orderMeal(
            new OrderId($orderId),
            $quantity,
            new MealId(Transliterator::transliterate($mealName))
        );
    }

    /**
     * @When :waitressName confirms that :customerName order confirmation number is :orderId at :time
     */
    public function confirmsThatOrderConfirmationNumberIsAt($waitressName, $customerName, $orderId, $time)
    {
        $this->orderService->confirmOrder(
            new OrderId($orderId),
            new \DateTime($time)
        );
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

    /**
     * @param string $customerName
     *
     * @return PhoneNumber
     */
    private function getPhoneNumberOfCustomer($customerName)
    {
        return $this->phones[$customerName];
    }
}
