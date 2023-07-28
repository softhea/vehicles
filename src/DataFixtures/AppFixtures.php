<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $password = $this->hasher->hashPassword($user, 'Test.1.One');
        $user->setEmail('user@example.com');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($password);
        $manager->persist($user);

        $viewer = new User();
        $password = $this->hasher->hashPassword($viewer, 'Test.1.One');
        $viewer->setEmail('viewer@example.com');
        $viewer->setRoles(['ROLE_VIEWER']);
        $viewer->setPassword($password);
        $manager->persist($viewer);

        $writer = new User();
        $password = $this->hasher->hashPassword($writer, 'Test.1.One');
        $writer->setEmail('writer@example.com');
        $writer->setRoles(['ROLE_WRITER']);
        $writer->setPassword($password);
        $manager->persist($writer);

        $manager->flush();
    }
}
