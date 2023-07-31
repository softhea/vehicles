<?php
declare(strict_types=1);

namespace App\Tests\Functional\Traits;

use App\Entity\Property;
use App\Entity\VehicleProperty;
use App\Repository\PropertyRepository;

trait PropertyTrait
{
    /**
     * @return Property[]
     */
    public function getFirstProperties(): array
    {
        /** @var PropertyRepository $propertyRepository */
        $propertyRepository = static::getContainer()->get(PropertyRepository::class);

        return $propertyRepository->findFirst(VehicleProperty::MAX_PROPERTIES_PER_VEHICLE);
    }
}
