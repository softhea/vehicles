<?php
declare(strict_types=1);

namespace App\Tests\Unit;

use App\Entity\VehicleProperty;
use App\Service\PropertyService;
use App\Service\VehiclePropertyService;
use App\Validator\VehiclePropertyValidator;
use Doctrine\ORM\EntityManager;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class VehiclePropertyServiceTest extends TestCase
{
    private VehiclePropertyService $vehiclePropertyService;
    private MockObject|VehiclePropertyValidator $vehiclePropertyValidator;
    private MockObject|EntityManager $entityManager;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManager::class);
        $propertyService = $this->createMock(PropertyService::class);
        $this->vehiclePropertyValidator = $this->createMock(VehiclePropertyValidator::class);

        $this->vehiclePropertyService = new VehiclePropertyService(
            $this->entityManager,
            $propertyService,
            $this->vehiclePropertyValidator
        );
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
        $this->vehiclePropertyValidator
            ->expects($this->once())
            ->method('validateValue');

        $vehicleProperty = new VehicleProperty();
        $vehicleProperty->setValue('initial_value');

        $this->vehiclePropertyService->updateValue($vehicleProperty, $value, $persist);

        $this->assertSame($value, $vehicleProperty->getValue());
    }    

    public function testUpdateValueEmptyStringThrowsException()
    {
        $this->expectExceptionMessage('Exception message');

        $this->vehiclePropertyValidator
            ->expects($this->once())
            ->method('validateValue')
            ->willThrowException(new Exception('Exception message'));

        $this->entityManager
            ->expects($this->never())
            ->method('flush');

        $this->vehiclePropertyService->updateValue(new VehicleProperty(), '');
    }   
}
