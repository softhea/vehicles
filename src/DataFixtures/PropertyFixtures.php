<?php
declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Property;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PropertyFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $property = new Property();
        $property->setName('year');
        $manager->persist($property);

        $property = new Property();
        $property->setName('engine_capacity');
        $manager->persist($property);

        $property = new Property();
        $property->setName('engine_power');
        $manager->persist($property);

        $property = new Property();
        $property->setName('fuel');
        $manager->persist($property);

        $property = new Property();
        $property->setName('top_speed');
        $manager->persist($property);

        $property = new Property();
        $property->setName('weight');
        $manager->persist($property);

        $property = new Property();
        $property->setName('color');
        $manager->persist($property);

        $property = new Property();
        $property->setName('tyre_sizes');
        $manager->persist($property);

        $manager->flush();
    }
}
