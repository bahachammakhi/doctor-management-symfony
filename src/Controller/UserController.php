<?php

namespace App\Controller;

use App\Form\UserType;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;

class UserController extends AbstractController
{

    #[Route('/user', name: 'app_user')]
    public function index(ManagerRegistry $doctrine,Request $request,UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encode the new users password
            $user->setPassword($passwordHasher->hashPassword($user, $user->getPassword()));

            // Set their role
            $user->setRoles(['ROLE_USER']);

            // Save
            $em = $doctrine->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'form' => $form->createView(),
        ]);
    }
}
