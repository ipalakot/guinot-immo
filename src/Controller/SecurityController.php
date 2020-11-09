<?php

namespace App\Controller;

use App\Entity\User;

use App\Form\RegistrationType;
use Serializable;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/enregistrement", name="admin.enregistrement")
     */
    public function enregistrement(EntityManagerInterface $manager, Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user= new User();
        $form= $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                $hash = $encoder-> EncodePassword($user, $user->getPassword());
                $user->setPassword($hash);
                $manager->persist($user);
                $manager->flush();

                return $this->redirectToRoute(admin.login);
            }
        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/login", name="admin.login")
     */
    public function login()
    {
        return $this->render('security/login.html.twig');
    }


    /**
     * @Route("/logout", name="admin.logout")
     */
    public function logout()
    {
        return $this->render('security/logout.html.twig');
    }
}

