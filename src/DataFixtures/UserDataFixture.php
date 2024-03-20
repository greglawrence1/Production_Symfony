<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserDataFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Create Bob
        $bob = new User();
        $bob->setEmail('bob@example.com');
        $bob->setPassword($this->hashPassword('123'));
        $bob->setRoles(['ROLE_ADMIN']);
        $manager->persist($bob);

        // Create Alice
        $alice = new User();
        $alice->setEmail('alice@example.com');
        $alice->setPassword($this->hashPassword('123'));
        $alice->setRoles(['ROLE_USER']);
        $manager->persist($alice);

        $manager->flush();
    }

    private function hashPassword(string $password): string
    {
        // You can use any password hashing method here, for example, bcrypt
        return password_hash($password, PASSWORD_BCRYPT);
    }
}
