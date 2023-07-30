<?php
declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Maker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MakerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $maker = new Maker();
        $maker->setName('BMW');
        $manager->persist($maker);

        $maker = new Maker();
        $maker->setName('Audi');
        $manager->persist($maker);

        $maker = new Maker();
        $maker->setName('VW');
        $manager->persist($maker);

        $manager->flush();
    }
}
