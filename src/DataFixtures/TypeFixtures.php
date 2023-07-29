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

        $type2 = new Type();
        $type2->setName('van');
        $manager->persist($type2);

        $type3 = new Type();
        $type3->setName('car');
        $manager->persist($type3);

        $manager->flush();
    }
}
