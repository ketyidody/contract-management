<?php

namespace App\Controller;

use App\Entity\Contract;
use App\Entity\RentalObject;
use App\Form\RentalObjectType;
use App\Repository\RentalObjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/rental-object")
 */
class RentalObjectController extends AbstractController
{
    /**
     * @Route("/", name="rental_object_index", methods={"GET"})
     */
    public function index(RentalObjectRepository $rentalObjectRepository): Response
    {
        return $this->render('rental_object/index.html.twig', [
            'rental_objects' => $rentalObjectRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="rental_object_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $rentalObject = new RentalObject();
        $form = $this->createForm(RentalObjectType::class, $rentalObject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rentalObject);
            $entityManager->flush();

            return $this->redirectToRoute('rental_object_index');
        }

        return $this->render('rental_object/new.html.twig', [
            'rental_object' => $rentalObject,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="rental_object_show", methods={"GET"})
     */
    public function show(RentalObject $rentalObject): Response
    {
        $sortedContracts = $this->getDoctrine()->getRepository(Contract::class)->getSortedContracts($rentalObject);
        return $this->render('rental_object/show.html.twig', [
            'rental_object' => $rentalObject,
            'sorted_contracts' => $sortedContracts,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="rental_object_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, RentalObject $rentalObject): Response
    {
        $form = $this->createForm(RentalObjectType::class, $rentalObject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rental_object_index');
        }

        return $this->render('rental_object/edit.html.twig', [
            'rental_object' => $rentalObject,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="rental_object_delete", methods={"DELETE"})
     */
    public function delete(Request $request, RentalObject $rentalObject): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rentalObject->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rentalObject);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rental_object_index');
    }
}
