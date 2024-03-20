<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserDataFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $bob = new User();
        $bob->setEmail('bob@example.com');
        $bob->setPassword('123');
        $bob->setRoles(['ROLE_ADMIN']);
        $manager->persist($bob);

        $alice = new User();
        $alice->setEmail('alice@example.com');
        $alice->setPassword('123');
        $alice->setRoles(['ROLE_USER']);
        $manager->persist($alice);

        $manager->flush();
    }


}
