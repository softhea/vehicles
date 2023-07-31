<?php
declare(strict_types=1);

namespace App\Tests\Unit;

use App\Entity\VehicleProperty;
use App\Service\VehiclePropertyService;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class VehiclePropertyServiceTest extends TestCase
{
    private VehiclePropertyService $vehiclePropertyService;
    private MockObject|EntityManager $entityManager;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManager::class);
        $this->vehiclePropertyService = new VehiclePropertyService($this->entityManager);
    }

    public function updateValueSuccessfullyDataProvider(): array
    {
        return [
            ['updated_value', true],
            ['updated_value', false],
            [null, true],
            [null, false],
        ];
    }

    /**
     * @dataProvider updateValueSuccessfullyDataProvider
     */
    public function testUpdateValueSuccessfully(?string $value, bool $persist)
    {
        if ($persist) {
            $this->entityManager
                ->expects($this->once())
                ->method('flush');
        } else {
            $this->entityManager
                ->expects($this->never())
                ->method('flush');
        }

        $vehicleProperty = new VehicleProperty();
        $vehicleProperty->setValue('initial_value');

        $this->vehiclePropertyService->updateValue($vehicleProperty, $value, $persist);

        $this->assertSame($value, $vehicleProperty->getValue());
    }    

    public function testUpdateValueEmptyStringThrowsException()
    {
        $this->expectExceptionMessage('Value of VehicleProperty cannot be an empty string!');

        $this->entityManager
            ->expects($this->never())
            ->method('flush');

        $this->vehiclePropertyService->updateValue(new VehicleProperty(), '');
    }   
}
