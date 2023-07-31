<?php
declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Vehicle;
use App\Entity\VehicleProperty;
use App\Repository\MakerRepository;
use App\Repository\PropertyRepository;
use App\Repository\TypeRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VehicleFixtures extends Fixture
{    
    private array $properties;
    private ObjectManager $manager;

    public function __construct(
        private MakerRepository $makerRepository,
        private TypeRepository $typeRepository,
        PropertyRepository $propertyRepository
    ) {
        $this->properties = $propertyRepository->findFirst(VehicleProperty::MAX_PROPERTIES_PER_VEHICLE);
    }

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;

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
        $this->addProperties($vehicle);
        $this->manager->persist($vehicle);

        $vehicle = new Vehicle();
        $vehicle->setModel('VW Transporter');
        $vehicle->setMaker($vwMaker);
        $vehicle->setType($vanType);
        $this->addProperties($vehicle);
        $this->manager->persist($vehicle);

        $vehicle = new Vehicle();
        $vehicle->setModel('BMV 320');
        $vehicle->setMaker($bmwMaker);
        $vehicle->setType($carType);
        $this->addProperties($vehicle);
        $this->manager->persist($vehicle);

        $vehicle = new Vehicle();
        $vehicle->setModel('BMV R');
        $vehicle->setMaker($bmwMaker);
        $vehicle->setType($motorcycleType);
        $this->addProperties($vehicle);
        $this->manager->persist($vehicle);

        $vehicle = new Vehicle();
        $vehicle->setModel('Audi A6');
        $vehicle->setMaker($audiMaker);
        $vehicle->setType($carType);
        $this->addProperties($vehicle);
        $this->manager->persist($vehicle);

        $this->manager->flush();
    }

    public function getDependencies()
    {
        return [
            MakerFixtures::class,
            TypeFixtures::class,
            PropertyFixtures::class,
        ];
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
