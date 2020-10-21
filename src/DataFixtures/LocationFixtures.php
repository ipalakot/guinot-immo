<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Location;

class LocationFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

// Creer occurence de 200 
for($i=1; $i<200; $i++){
    $location = new Location();
    $location->setDenomination("Denomination du Bien en Location ° $i")
                ->setCategorie(" Appt / Maison / Villa / Hôtels... ")
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
$manager->flush();
}
}
