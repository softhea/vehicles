<?php
declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Property;
use App\Entity\Vehicle;
use App\Entity\VehicleProperty;
use App\Repository\MakerRepository;
use App\Repository\PropertyRepository;
use App\Repository\TypeRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VehicleFixtures extends Fixture
{    
    /** @var Property[] */
    private array $properties;
    private ObjectManager $manager;

    public function __construct(
        private MakerRepository $makerRepository,
        private TypeRepository $typeRepository
    ) {}

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;

        $this->createProperties();

        $vwMaker = $this->makerRepository->findOneBy(['name' => 'VW']);
        $bmwMaker = $this->makerRepository->findOneBy(['name' => 'BMW']);
        $audiMaker = $this->makerRepository->findOneBy(['name' => 'Audi']);

        $carType = $this->typeRepository->findOneBy(['name' => 'car']);
        $vanType = $this->typeRepository->findOneBy(['name' => 'van']);
        $motorcycleType = $this->typeRepository->findOneBy(['name' => 'motorcycle']);

        $vehicle = new Vehicle();
        $vehicle->setModel('VW Golf 7');
        $vehicle->setMaker($vwMaker);
        $vehicle->setType($carType);
        $this->manager->persist($vehicle);
        $this->addProperties($vehicle);

        $vehicle = new Vehicle();
        $vehicle->setModel('VW Transporter');
        $vehicle->setMaker($vwMaker);
        $vehicle->setType($vanType);
        $this->manager->persist($vehicle);
        $this->addProperties($vehicle);

        $vehicle = new Vehicle();
        $vehicle->setModel('BMV 320');
        $vehicle->setMaker($bmwMaker);
        $vehicle->setType($carType);
        $this->manager->persist($vehicle);
        $this->addProperties($vehicle);

        $vehicle = new Vehicle();
        $vehicle->setModel('BMV R');
        $vehicle->setMaker($bmwMaker);
        $vehicle->setType($motorcycleType);
        $this->manager->persist($vehicle);
        $this->addProperties($vehicle);

        $vehicle = new Vehicle();
        $vehicle->setModel('Audi A6');
        $vehicle->setMaker($audiMaker);
        $vehicle->setType($carType);
        $this->manager->persist($vehicle);
        $this->addProperties($vehicle);
        
        $this->manager->flush();
    }

    public function getDependencies()
    {
        return [
            MakerFixtures::class,
            TypeFixtures::class,
        ];
    }

    private function createProperties()
    {
        $property = new Property();
        $property->setName('year');
        $this->manager->persist($property);
        $this->properties[] = $property;

        $property = new Property();
        $property->setName('engine_capacity');
        $this->manager->persist($property);
        $this->properties[] = $property;

        $property = new Property();
        $property->setName('engine_power');
        $this->manager->persist($property);
        $this->properties[] = $property;

        $property = new Property();
        $property->setName('fuel');
        $this->manager->persist($property);
        $this->properties[] = $property;

        $property = new Property();
        $property->setName('top_speed');
        $this->manager->persist($property);
        $this->properties[] = $property;

        $property = new Property();
        $property->setName('weight');
        $this->manager->persist($property);
        $this->properties[] = $property;

        $property = new Property();
        $property->setName('color');
        $this->manager->persist($property);
        $this->properties[] = $property;

        $property = new Property();
        $property->setName('tyre_sizes');
        $this->manager->persist($property);
        $this->properties[] = $property;

        $this->manager->flush();
    }

    private function addProperties(Vehicle $vehicle): void
    {
        foreach ($this->properties as $property) {
            $vehicleProperty = new VehicleProperty();
            $vehicleProperty->setVehicle($vehicle);
            $vehicleProperty->setProperty($property);
            $vehicleProperty->setValue('test');

            $this->manager->persist($vehicleProperty);
        }
    }
}
