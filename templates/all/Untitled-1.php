
/**
     * Affichage aux users de terrains
     * @param PaginatorInterface $paginator,
     * @param Request $request,
     * @Route("/location/terrains", name="location.terrains.index")
     * @param
     */
    public function terrains(LocationRepository $locationrepo, Request $request)
    {
        $locations= $locationrepo->(
            ['pays'=>'France']
         );

       // Appel de la page pour affichage
        return $this->render('location/terrains.html.twig', [
            // passage du contenu de $location
            'locations'=>$locations
        ]);
    }


