<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    #[Route('/login', name: 'login')]
    public function login(): Response
    {
        return $this->render('auth/login.html.twig', [
            'controller_name' => 'AuthController',
        ]);
    }

    #[Route('/sign-up', name: 'sign-up')]
    public function signUp(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user); 

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();
        }

        return $this->render('auth/sign-up.html.twig', [
            'controller_name' => 'AuthController',
            'form' => $form->createView()
        ]);
    }

    #[Route('/registration', name:'registration')]
    public function registration(Request $request, UserPasswordHasherInterface $passwordHasher)
    {
        $user = new User();
        $plaintextPassword = $user->getPassword();

        $hashedPassword = $passwordHasher->hashPassword($user, $plaintextPassword);
        $user->setPassword($hashedPassword);

    }
}
