<?php

namespace App\Controller;

use App\Entity\Location;

use App\Repository\LocationRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;


class LocationController extends AbstractController
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
     * Affichage aux users de Biens en location
     * @param
     * @Route("/location", name="location.index")
     * @param
     */
    public function index(LocationRepository $locarepo, PaginatorInterface $paginator, Request $request)
    {
    // Connexion à ma BD
       // $repo = $this->getDoctrine()->getRepository(Immobilier::class);
        $locations = $paginator->paginate(
            $locarepo->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
         );

       // Appel de la page pour affichage
        return $this->render('location/index.html.twig', [
            // passage du contenu de $immobilier
            'locations'=>$locations
        ]);
    }


    /**
     * Administration de Biens locatifs
     * @param
     * @Route("/admin/location", name="location_admin.index")
     * @param
     */
    public function admin(LocationRepository $locarepo, PaginatorInterface $paginator, Request $request)
    {
    // Connexion à ma BD
       // $repo = $this->getDoctrine()->getRepository(Immobilier::class);
        $locations = $paginator->paginate(
            $locarepo->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            25 /*limit per page*/
         );

       // Appel de la page pour affichage
        return $this->render('location/admin.html.twig', [
            // passage du contenu de $immobilier
            'locations'=>$locations
        ]);
    }

    /** 
     * Creation de Bien en Admin
     * @param Request $request
     * @Route("admin/location/nouveau", name="location.nouveau.admin")
     * @param Response
    */
    
    // Creation de Location
    public function nouvellocation(Request $request): Response
    {
        $location = new Location();

    // Creation du Formaulaire avec CreateFormBuilder
        $form = $this->createFormBuilder($location)
                    ->add('denomination')
                    ->add('categorie')                
                    ->add('photo')   
                    ->add('description')
                    ->add('surface')                
                    ->add('type')     
                    ->add('chambre')
                    ->add('etage')                
                    ->add('prix')    
                    ->add('adresse')
                    ->add('cp')                
                    ->add('ville')    
                    ->add('pays')      
                    ->add('accessibility')          

        //Utiser la Function GetForm pour voir le resultat Final
                    ->getForm();
        
        // Traitement de la requete (http) passée en parametre
        $form->handleRequest($request);

        // Test sur le Remplissage / la soummision et la validité des champs
        if ($form->isSubmitted() && $form->isValid()) {
            
            // Affectation de la Date à mon article
            $location->setCreatedAt(new \DateTime());

            $this->em->persist($location);
            $this->em->flush();

            //Enregistrement et Retour sur la page de l'article
            return $this->redirectToRoute('location.nouveau', ['id'=>$location->getId()]);
        }
                     
        //Passage à Twig des Variable à afficher avec lmethode CreateView
        return $this->render('location/nouveau.html.twig', [
            'immobilier'=>$location,
            'formlocation' => $form->createView()
        ]);
    }



    // Edition de Biens locatifs 
    public function edit($id, location $location, Request $request)
    {
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
            
        // $entityManager = $this->getDoctrine()->getManager();
        // $this->em->persist($immobilier); // Pas besoin de faire de Persistance ici, L'objet vient de la Base de données
           $this->em->flush();
            

        //Enregistrement et Retour sur la page de l'article
            return $this->redirectToRoute('index.affich', ['id'=>$immobilier->getId()]);
        }
         
            
        //aPassage à Twig des Variable à afficher avec lmethode CreateView
        return $this->render('home/nouveau.html.twig', [
            'formImmobilier' => $form->createView()
        ]);
    }


}
