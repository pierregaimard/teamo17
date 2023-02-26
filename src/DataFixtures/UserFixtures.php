<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly string $adminPassword,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail("matthieu@teamo17.fr");
        $user->setRoles([User::ROLE_ADMIN]);
        $user->setPassword($this->passwordHasher->hashPassword($user, $this->adminPassword));
        $user->setIsActive(true);
        $manager->persist($user);

        $manager->flush();
    }
}
