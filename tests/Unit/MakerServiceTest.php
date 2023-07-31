<?php
declare(strict_types=1);

namespace App\Tests\Unit;

use App\Entity\Maker;
use App\Entity\Type;
use App\Entity\Vehicle;
use App\Repository\MakerRepository;
use App\Service\MakerService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class MakerServiceTest extends TestCase
{
    private MakerService $makerService;
    private MockObject|MakerRepository $makerRepository;

    protected function setUp(): void
    {
        $this->makerRepository = $this->createMock(MakerRepository::class);
        $this->makerService = new MakerService($this->makerRepository);

        $maker = new Maker();
        $maker->setName('BMW');// Audi VW

        $type = new Type();
        $type->setName('motorcycle'); // var car

        $vehicle = new Vehicle();
        $vehicle
            ->setModel('BMV R')
            ->setMaker($maker)
            ->setType($type);
    }

    public function testListSuccessfully()
    {
        $expected = [
            (new Maker())->setName('BMW'),
            (new Maker())->setName('Audio'),
            (new Maker())->setName('VW'),
        ];
        $this->makerRepository
            ->expects($this->never())
            ->method('findByTypeId');
        $this->makerRepository
            ->expects($this->once())
            ->method('findBy')->willReturn($expected);

        $makers = $this->makerService->list();

        $this->assertSame($expected, $makers);
    }    

    public function testFilteredListEmpty()
    {
        $this->makerRepository
            ->expects($this->never())
            ->method('findBy');
        $this->makerRepository
            ->expects($this->once())
            ->method('findByTypeId')->willReturn([]);

        $makers = $this->makerService->list(999);

        $this->assertSame([], $makers);
    } 

    public function testFilteredListSuccessfully()
    {
        $expected = [
            (new Maker())->setName('BMW'),
            (new Maker())->setName('Audio'),
        ];
        $this->makerRepository
            ->expects($this->never())
            ->method('findBy');
        $this->makerRepository
            ->expects($this->once())
            ->method('findByTypeId')
            ->willReturn($expected);

        $makers = $this->makerService->list(1);

        $this->assertSame($expected, $makers);
    } 
}
