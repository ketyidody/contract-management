<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class IndexController extends AbstractController
{

    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function indexAction(Request $request)
    {
        return $this->render('home.html.twig');
    }
}