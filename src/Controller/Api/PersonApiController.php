<?php

namespace App\Controller\Api;

use App\Entity\Person;
use App\Repository\PersonRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/person")
 */
class PersonApiController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/index")
     *
     * @return Response
     */
    public function index(PersonRepository $personRepository)
    {
        $persons = $personRepository->findAll();

        $view = $this->view($persons)
            ->setFormat('json')
            ->setHeaders([
                'Content-Type' => 'application/json',
                'Access-Control-Allow-Origin' => '*'
            ])
        ;

        return $this->handleView($view);
    }

    /**
     * @Route("/show/{personId}", methods={"GET"})
     * @param $personId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show($personId)
    {
        $person = $this->getDoctrine()->getRepository(Person::class)->find($personId);
        $view = $this->view($person)
            ->setFormat('json')
            ->setHeaders([
                'Content-Type' => 'application/json',
                'Access-Control-Allow-Origin' => '*'
            ])
        ;

        return $this->handleView($view);
    }
}