<?php

namespace App\Controller\Api;

use App\Entity\RentalObject;
use App\Repository\RentalObjectRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/rental_object")
 */
class RentalObjectApiController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/index")
     *
     * @return Response
     */
    public function index(RentalObjectRepository $rentalObjectRepository)
    {
        $rentalObjects = $rentalObjectRepository->findAll();

        $view = $this->view($rentalObjects)
            ->setFormat('json')
            ->setHeaders([
                'Content-Type' => 'application/json',
                'Access-Control-Allow-Origin' => '*'
            ])
        ;

        return $this->handleView($view);
    }

    /**
     * @Route("/show/{rentalObjectId}", methods={"GET"})
     * @param $rentalObjectId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show($rentalObjectId)
    {
        $rentalObject = $this->getDoctrine()->getRepository(RentalObject::class)->find($rentalObjectId);
        $view = $this->view($rentalObject)
            ->setFormat('json')
            ->setHeaders([
                'Content-Type' => 'application/json',
                'Access-Control-Allow-Origin' => '*'
            ])
        ;

        return $this->handleView($view);
    }
}