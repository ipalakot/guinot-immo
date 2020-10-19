<?php

namespace App\Controller;

use App\Entity\Immobilier;
use App\Entity\ImmoVente;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;

class HomeController extends AbstractController
{
    protected $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    /**
     * @Route("/", name="index")
     * @Route("/accueil", name="index.accueil")
     */
    public function index()
    {
        // Connexion à ma BD
        $repo = $this->getDoctrine()->getRepository(Immobilier::class);
        $immobiliers = $repo->findAll();

       // Appel de la page pour affichage
        return $this->render('home/index.html.twig', [
            // passage du contenu de $immobilier
            'immobiliers'=>$immobiliers
        ]);
    }

    /** 
     * @Route("/immo/nouveau", name="immo.nouveau")
    */
    
    // Creation d'un nouveau Bien
    public function nouveau(Request $request)
    {
        $entityManager = $this->entityManager;
        $immobilier = new Immobilier();

        // Demande de al creation du Formaulaire avec CreateFormBuilder
        $form = $this->createFormBuilder($immobilier)
                    ->add('titre')
                    ->add('photo')                
                    ->add('description')    

        //Utiser la Function GetForm pour voir le resultat Final
                    ->getForm();
        
        // Traitement de la requete (http) passée en parametre
        $form->handleRequest($request);

        // Test sur le Remplissage / la soummision et la validité des champs
        if ($form->isSubmitted() && $form->isValid()) {
            
            // Affectation de la Date à mon article
            $immobilier->setCreatedAt(new \DateTime());

            $entityManager->persist($immobilier);
            $entityManager->flush();

            //Enregistrement et Retour sur la page de l'article
            return $this->redirectToRoute('immo.nouveau', ['id'=>$immobilier->getId()]);
        }
         
            
        //aPassage à Twig des Variable à afficher avec lmethode CreateView
        return $this->render('home/nouveau.html.twig', [
            'formImmobilier' => $form->createView()
        ]);
    }


    /** 
     * @Route("/immo/{id}/edit", name="immo.edition", methods="GET|POST")
    */
    
    // Edition d'un Bien
    public function edit($id,Request $request, EntityManagerInterface $entityManager )
    {

        $immobilier =  $entityManager->getRepository(Immobilier::class)->find($id);

        // Demande de al creation du Formaulaire avec CreateFormBuilder
        $form = $this->createFormBuilder($immobilier)
                    ->add('titre')
                    ->add('photo')                
                    ->add('description')    

        //Utiser la Function GetForm pour voir le resultat Final
                    ->getForm();
        
        // Traitement de la requete (http) passée en parametre
        $form->handleRequest($request);

        // Test sur le Remplissage / la soummision et la validité des champs
        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($immobilier);
            $entityManager->flush();

            //Enregistrement et Retour sur la page de l'article
            return $this->redirectToRoute('index.affich', ['id'=>$immobilier->getId()]);
        }
         
            
        //aPassage à Twig des Variable à afficher avec lmethode CreateView
        return $this->render('home/nouveau.html.twig', [
            'formImmobilier' => $form->createView()
        ]);
    }
// Modification de bien avec ImmoVente
 /** 
  * @Route("/immo/{id}/edit", name="immo.modif", methods="GET|POST")
  */  

/*  public function modif(ImmoVente $immovente, Request $request)
    {

        $immovente = new ImmoVente();

        // Demande de al creation du Formaulaire avec CreateFormBuilder
        $form = $this->createFormBuilder($immovente)
                    ->add('titre')
                    ->add('photo')                
                    ->add('description')    

        //Utiser la Function GetForm pour voir le resultat Final
                    ->getForm();
        
        // Traitement de la requete (http) passée en parametre
        $form->handleRequest($request);

        // Test sur le Remplissage / la soummision et la validité des champs
        if ($form->isSubmitted() && $form->isValid()) {
            
            // Affectation de la Date à mon article

            if (! $immovente->getId()){
                  $immovente->setCreatedAt(new \DateTime());
                }

            $entityManager->persist($immovente );
            $entityManager->flush();

            //Enregistrement et Retour sur la page de l'article
            return $this->redirectToRoute('index.affich', ['id'=>$immovente->getId()]);
        }
         
            
        //aPassage à Twig des Variable à afficher avec lmethode CreateView
        return $this->render('home/nouveau.html.twig', [
            'formImmobilier' => $form->createView()
        ]);
    }

*/
    /**
    * @Route("/immo/{id}", name="index.affich")
    */
    // recuperation de l'identifiant
    public function affich($id ) 
    {
        // Appel à Doctrine & au repository
        $repo = $this->getDoctrine()->getRepository(Immobilier::class);

        //Recherche de l'article avec son identifaint
        $immobilier = $repo->find($id);
        // Passage à Twig de tableau avec des variables à utiliser
        return $this->render('home/affich.html.twig', [
            'controller_name' => 'HomeController',
            'immobilier' => $immobilier
        ]);
    }


    /**
    * @Route("/apropos", name="apropos")
    */
    public function apropos()
    {
        return $this->render('home/apropos.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
    * @Route("/page", name="index.page")
    */
    public function page()
    {
        return $this->render('home/page.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

}
