<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UtilisateursFixtures extends Fixture
{
    public function __construct(UserPasswordEncoderInterface $encoder)
    { 
        $this->encoder =$encoder;
    }
    
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $utilisateurs = new Utilisateurs();

        $utilisateurs->setNoms('palakot');
        $utilisateurs->setPrenoms('igor');
        $utilisateurs->setLogin('ipalakot');

        $utilisateurs->setPassword($this->encoder->EncodePassword($utilisateurs, 'ipalakot'));
        
        $utilisateurs->setEmail('ipalakot@mail.com');  

        $manager-> persist($utilisateurs);

        $manager->flush();
    }
}
