<?php

class CreateDormerCalculationCommand
{
    private $entityManager;

    private $tokenStorage;

    private $session;

    private $translator;

    public function __construct(EntityManager $entityManager, TokenStorageInterface $tokenStorage, Session $session, Translator $translator)
    {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
        $this->session = $session;
        $this->translator = $translator;
    }
}
