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

    // Creer occurence de 10 Categroie
    for($i=1; $i<5; $i++){
        $categorie = new Categorie();
        $categorie->setTitre("Categorie $i")
                ->setResume("Resume de la categorie");

        $manager->persist($categorie);

// Mainteannt je cree mes Bien Locatifs
        for($j=1; $j<10; $j++){
            $location = new Location();
            $location->setDenomination("Denomination du Bien en Location ° $i")
                        ->setCategorie($categorie)
                        ->setPhoto("http://placehold.it/300x200")
                        ->setCreatedAt(new \DateTime())
                        ->setDescription(" Appt / Maison / Villa / Hôtels... ")
                        ->setSurface(200)
                        ->setType(" Type du Bien ")
                        ->setChambre(4)
                        ->setEtage(2)
                        ->setPrix(200)
                        ->setAdresse(00000)
                        ->setCp(000)
                        ->setVille("Ville ")
                        ->setPays("Ville ")
                        ->setAccessibility(1);
            $manager->persist($location);
        }
    }

$manager->flush();
}
}
