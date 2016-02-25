<?php

class CalculationHandler
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var Session
     */
    private $session;

    /**
     * @var Translator
     */
    private $translator;

    /**
     * @param EntityManager $entityManager
     * @param TokenStorageInterface $tokenStorage
     * @param Session $session
     * @param Translator $translator
     *
     * FIXME null values here are just to make prototype work
     */
    public function __construct(
        EntityManager $entityManager,
        TokenStorageInterface $tokenStorage = null,
        Session $session = null,
        Translator $translator = null
    ) {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
        $this->session = $session;
        $this->translator = $translator;
    }

    /**
     * @param CalculationCommand $command
     */
    public function handle($command)
    {
        // transfer required args from command to construct. that way object is in valid state
        $entity = new DormerCalculation();// Command could contain necessary args for this object construct
        $entity->addPrice('total', $command->subTotal, $command->quantity);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        // do other stuff with entity (translator etc.)
    }
}
