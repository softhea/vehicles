<?php
declare(strict_types=1);

namespace App\Tests\Functional\Trait;

use App\Entity\VehicleProperty;
use App\Repository\VehiclePropertyRepository;

trait VehiclePropertyTrait
{
    public function getFirstVehicleProperty(): ?VehicleProperty
    {
        /** @var VehiclePropertyRepository $vehiclePropertyRepository */
        $vehiclePropertyRepository = static::getContainer()->get(VehiclePropertyRepository::class);

        return $vehiclePropertyRepository->findOneBy([], ['id' => 'asc']);
    }

    public function findVehicleProperty(int $id): ?VehicleProperty
    {
        /** @var VehiclePropertyRepository $vehiclePropertyRepository */
        $vehiclePropertyRepository = static::getContainer()->get(VehiclePropertyRepository::class);

        return $vehiclePropertyRepository->find($id);
    }
}
