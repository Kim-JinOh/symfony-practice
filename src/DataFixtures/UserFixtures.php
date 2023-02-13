<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $user = new User();
        $user->setEmail('test@test.test');
        $user->setPassword('qwe123');
        // $hashedPassword = $passwordHasher->hashPassword($user, $user->getPassword());
        // $user->setPassword($hashedPassword);

        $manager->flush();
    }
}
