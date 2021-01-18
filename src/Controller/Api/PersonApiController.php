<?php

namespace App\Controller\Api;

use App\Entity\Person;
use App\Repository\PersonRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/persons")
 */
class PersonApiController extends AbstractFOSRestController
{
    /**
     * @Route("/index", methods={"GET"})
     */
    public function index(PersonRepository $personRepository)
    {
        $persons = $personRepository->findAll();
        $view = $this->view($persons, 200);

        return $this->handleView($view);
    }

    /**
     * @Route("/show/{id}", methods={"GET"})
     */
    public function show(Person $person)
    {
        $view = $this->view($person, 200);

        return $this->handleView($view);
    }
}