<?php
declare(strict_types=1);

namespace App\Tests\Functional\Traits;

use App\Entity\Vehicle;
use App\Repository\VehicleRepository;

trait VehicleTrait
{
    public function getFirstVehicle(): ?Vehicle
    {
        /** @var VehicleRepository $vehicleRepository */
        $vehicleRepository = static::getContainer()->get(VehicleRepository::class);

        return $vehicleRepository->findOneBy([], ['id' => 'asc']);
    }
}
