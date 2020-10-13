<?php

namespace App\Controller;

use render;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    /**
     * 
     * @Route("/default", name="default")
     * 
     */
    public function index()
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'day' => "mardi"
        ]);
    }

    /**
    * @Route("/", name="accueil")
    */
    public function accueil()
    {
        return $this->render('default/accueil.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

}
