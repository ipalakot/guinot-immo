<?php

namespace App\Controller;

use App\Repository\LocationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

class HomeController extends AbstractController
{
    /**
     * @param ImmobilierRepository $immobilierrepository
     * @param EntityManageInterface $em
     * @return void
     */
 
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    
    /**
     * @param
     * @Route("/", name="index")
     * @Route("/accueil", name="index.accueil")
     */
    public function index(LocationRepository $locationRepository, Request $request)
    {
    // Connexion à ma BD
       // $repo = $this->getDoctrine()->getRepository(Immobilier::class);
        $locations = $locationRepository->findAll();

       // Appel de la page pour affichage
        return $this->render('home/index.html.twig', [
            // passage du contenu de $immobilier
            'locations'=>$locations
        ]);
    }



}
