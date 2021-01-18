<?php

namespace App\Controller\Api;

use App\Entity\Contract;
use App\Repository\ContractRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @Route("/contract")
 */
class ContractApiController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/index")
     *
     * @return Response
     */
    public function index(ContractRepository $contractRepository)
    {
        $contracts = $contractRepository->findAll();

        $view = $this->view($contracts)
            ->setFormat('json')
            ->setHeaders([
                'Content-Type' => 'application/json',
                'Access-Control-Allow-Origin' => '*'
            ])
        ;

        return $this->handleView($view);
    }

    /**
     * @Route("/show/{contractId}", methods={"GET"})
     * @param Contract $contract
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show($contractId)
    {
        $contract = $this->getDoctrine()->getRepository(Contract::class)->find($contractId);
        $view = $this->view($contract)
            ->setFormat('json')
            ->setHeaders([
                'Content-Type' => 'application/json',
                'Access-Control-Allow-Origin' => '*'
            ])
        ;

        return $this->handleView($view);
    }
}