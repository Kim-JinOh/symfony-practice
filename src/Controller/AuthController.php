<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function signUp(): Response
    {
        return $this->render('auth/sign-up.html.twig', [
            'controller_name' => 'AuthController',
        ]);
    }

    #[Route('/registration', name:'registration')]
    public function registration(UserPasswordHasherInterface $passwordHasher)
    {
        $user = new User();
        $plaintextPassword = $user->getPassword();

        $hashedPassword = $passwordHasher->hashPassword($user, $plaintextPassword);
        $user->setPassword($hashedPassword);

    }
}
