<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Vehicle;
use App\Entity\VehicleProperty;
use App\Validator\VehiclePropertyValidator;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class VehiclePropertyService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private PropertyService $propertyService,
        private VehiclePropertyValidator $vehiclePropertyValidator
    ) {}
    
    /**
     * @throws Exception
     */
    public function create(Vehicle $vehicle, string $name, ?string $value, bool $persist = true): VehicleProperty
    {
        $this->vehiclePropertyValidator->validateCreate($vehicle, $name, $value);

        $property = $this->propertyService->findOrCreate($name);

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
        $this->vehiclePropertyValidator->validateValue($value);

        $vehicleProperty->setValue($value);

        if ($persist) {
            $this->entityManager->flush();
        }
    }
}
