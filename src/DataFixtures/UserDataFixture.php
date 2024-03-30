<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserDataFixture extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $bob = new User();
        $bob->setEmail('bob@example.com');
        $hashedPassword = $this->passwordHasher->hashPassword($bob, '123');
        $bob->setPassword($hashedPassword);
        $bob->setRoles(['ROLE_ADMIN']);
        $manager->persist($bob);

        $alice = new User();
        $alice->setEmail('alice@example.com');
        $hashedPassword = $this->passwordHasher->hashPassword($alice, '123');
        $alice->setPassword($hashedPassword);
        $alice->setRoles(['ROLE_USER']);
        $manager->persist($alice);

        $manager->flush();
    }
}
