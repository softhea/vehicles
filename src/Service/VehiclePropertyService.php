<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Vehicle;
use App\Entity\VehicleProperty;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class VehiclePropertyService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private PropertyRepository $propertyRepository,
    ) {}
    
    /**
     * @throws Exception
     */
    public function create(Vehicle $vehicle, string $name, ?string $value, bool $persist = true): VehicleProperty
    {
        // todo move validation
        if ('' === $value) {
            throw new Exception('Value of VehicleProperty cannot be an empty string!');
        }

        // todo move validation
        if (VehicleProperty::MAX_PROPERTIES_PER_VEHICLE <= $vehicle->getProperties()->count()) {
            throw new Exception('Max No of Vehicle Properties already achieved!');
        }

        // todo move find or create 
        // todo validate name
        $property = $this->propertyRepository->findOneBy(['name' => $name]);

        $vehicleProperty = new VehicleProperty();
        $vehicleProperty->setVehicle($vehicle);
        $vehicleProperty->setProperty($property);
        $vehicleProperty->setValue($value);

        $this->entityManager->persist($vehicleProperty);

        if ($persist) {
            $this->entityManager->flush();
        }

        return $vehicleProperty;
    }

    /**
     * @throws Exception
     */
    public function updateValue(VehicleProperty $vehicleProperty, ?string $value, bool $persist = true): void
    {
        if ('' === $value) {
            throw new Exception('Value of VehicleProperty cannot be an empty string!');
        }

        $vehicleProperty->setValue($value);

        if ($persist) {
            $this->entityManager->flush();
        }
    }
}
