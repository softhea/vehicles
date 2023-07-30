<?php
declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher) {}
    
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $password = $this->hasher->hashPassword($user, 'Test.1.One');
        $user->setEmail('user@example.com');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($password);
        $manager->persist($user);

        $user = new User();
        $password = $this->hasher->hashPassword($user, 'Test.1.One');
        $user->setEmail('viewer@example.com');
        $user->setRoles(['ROLE_VIEWER']);
        $user->setPassword($password);
        $manager->persist($user);

        $user = new User();
        $password = $this->hasher->hashPassword($user, 'Test.1.One');
        $user->setEmail('writer@example.com');
        $user->setRoles(['ROLE_WRITER']);
        $user->setPassword($password);
        $manager->persist($user);

        $manager->flush();
    }
}
