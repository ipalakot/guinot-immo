<?php

namespace App\Controller;

use App\Entity\Location;
use App\Repository\LocationRepository;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class LocationController extends AbstractController
{ 
    /**
     * @param LocationRepository $locationrepository
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
       // $repo = $this->getDoctrine()->getRepository(Location::class);
        $locations = $paginator->paginate(
            $locarepo->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
         );

       // Appel de la page pour affichage
        return $this->render('location/index.html.twig', [
            // passage du contenu de $location
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
       // $repo = $this->getDoctrine()->getRepository(Location::class);
        $locations = $paginator->paginate(
            $locarepo->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            25 /*limit per page*/
         );

       // Appel de la page pour affichage
        return $this->render('location/admin.html.twig', [
            // passage du contenu de $location
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
                    ->add('categorie', EntityType::class, [
                        // looks for choices from this entity
                            'class' => Categorie::class,
                        // uses the User.username property as the visible option string
                        'choice_label' => 'titre'])                
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
            return $this->redirectToRoute('location.nouveau.admin', ['id'=>$location->getId()]);
        }
                     
        //Passage à Twig des Variable à afficher avec lmethode CreateView
        return $this->render('location/nouveau.html.twig', [
            'location'=>$location,
            'formlocation' => $form->createView()
        ]);
    }


    /** 
     * // Edition de Biens locatifs 
     * @param Request $request
     * @param Location $location
     * @Route("admin/loca/{id}/edit", name="location.edition", methods="GET|POST")
     * @param void
    */
    public function edit($id, location $location, Request $request)
    {
        // Demande de al creation du Formaulaire avec CreateFormBuilder
                $form = $this->createFormBuilder($location)
                ->add('denomination')
                ->add('categorie', EntityType::class, [
                    // looks for choices from this entity
                        'class' => Categorie::class,
                    // uses the User.username property as the visible option string
                    'choice_label' => 'titre'])                
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
            
        // $entityManager = $this->getDoctrine()->getManager();
        // $this->em->persist($location); // Pas besoin de faire de Persistance ici, L'objet vient de la Base de données
           $this->em->flush();
            

        //Enregistrement et Retour sur la page de l'article
            return $this->redirectToRoute('location_admin.index');
        }
         
            
        //aPassage à Twig des Variable à afficher avec lmethode CreateView
        return $this->render('location/nouveau.html.twig', [
            'formlocation' => $form->createView()
        ]);
    }

    
    /**
     * Affiche en details d'un Bien locatif
     * @param $id
     * @param LocationRepository $immorepo
     * @Route("/location/{id}", name="location.affich")
     * @param 
    */
    // recuperation de l'identifiant
    public function affichage($id, LocationRepository $locarepo ) 
    {
        // Appel à Doctrine & au repository
        // $repo = $this->getDoctrine()->getRepository(Location::class);

        //Recherche de l'article avec son identifaint
        $location = $locarepo->find($id);
        // Passage à Twig de tableau avec des variables à utiliser
        return $this->render('location/affich.html.twig', [
            'controller_name' => 'LocationController',
            'location' => $location
        ]);
    }

    
    /**
     * Suupression d'un Bien locatif
     * @Route("admin/loca/{id}/delete", name="loca.delete", methods={"DELETE"})
     */
    // recuperation de l'identifiant
    public function delete(Request $request, Location $location): Response
    {
        if ($this->isCsrfTokenValid('delete'.$location->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($location);
            $entityManager->flush();
        }
        return $this->redirectToRoute('location_admin.index');
    }



}
