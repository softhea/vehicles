<?php
declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TypeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $type = new Type();
        $type->setName('motorcycle');
        $manager->persist($type);

        $type = new Type();
        $type->setName('van');
        $manager->persist($type);

        $type = new Type();
        $type->setName('car');
        $manager->persist($type);

        $manager->flush();
    }
}
