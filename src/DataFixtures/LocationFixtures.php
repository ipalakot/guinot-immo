<?php

namespace App\DataFixtures;

use App\Entity\Location;
use App\Entity\Categorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;



class LocationFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
    
 //   $faker = \Faker\Factory::create('fr_FR');
    
    // Creer occurence de 10 Categroie
    for($i=1; $i<5; $i++){
        $categorie = new Categorie();
        $categorie->setTitre("Titre de Categorie")
                ->setResume("Resume");

        $manager->persist($categorie);

// Mainteannt je cree mes Bien Locatifs
        for($j=1; $j<10; $j++){
            $location = new Location();
            $location->setDenomination("Denomination")
                        ->setCategorie($categorie)
                        ->setPhoto("http://placehold.it/300x200")
                        ->setCreatedAt(new \DateTime())
                        ->setDescription("... sur la mise en page elle-même. L'avantage du Lorem Ipsum sur un texte générique comme 'Du texte. Du texte. Du texte.' est qu'il possède une distribution de lettres plus ou moins normale, et en tout cas comparable avec celle du français standard. De nombreuses suites logicielles de mise en page ou éditeurs de sites Web ont fait du Lorem Ipsum leur faux texte par défaut, et une recherche pour 'Lorem Ipsum' vous conduira vers de nombreux sites qui n'en sont encore qu'à leur phase de construction. Plusieurs versions sont apparues avec le temps, parfois par accident, souvent intentionnellemen")
                        ->setSurface(111)
                        ->setType("XXXX")
                        ->setChambre(000)
                        ->setEtage(000)
                        ->setPrix(000)
                        ->setAdresse("xxxxxxxx")
                        ->setCp(000)
                        ->setVille("xxxxxxxxx")
                        ->setPays("xxxxxxx")
                        ->setAccessibility(00);
            $manager->persist($location);
        }
    }

$manager->flush();
}
}
