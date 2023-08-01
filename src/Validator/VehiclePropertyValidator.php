<?php
declare(strict_types=1);

namespace App\Validator;

use App\Entity\Vehicle;
use App\Entity\VehicleProperty;
use Exception;

class VehiclePropertyValidator
{ 
    /**
     * @throws Exception
     */
    public function validateCreate(Vehicle $vehicle, string $name, ?string $value): void
    {
        $this->validateMaxNoOfVehicleProperties($vehicle);
        $this->validateName($name);
        $this->validateValue($value);
    }

    /**
     * @throws Exception
     */
    public function validateValue(?string $value): void
    {
        if ('' === $value) {
            throw new Exception('Value of VehicleProperty cannot be an empty string!');
        }
    }

    public function validateName(string $name): void
    {
        if ('' === $name) {
            throw new Exception('Name of VehicleProperty cannot be an empty string!');
        }
    }

    /**
     * @throws Exception
     */
    public function validateMaxNoOfVehicleProperties(Vehicle $vehicle): void
    {
        if (VehicleProperty::MAX_PROPERTIES_PER_VEHICLE <= $vehicle->getProperties()->count()) {
            throw new Exception('Max No of Vehicle Properties already achieved!');
        }
    }
}
