<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Maker;
use App\Repository\MakerRepository;

class MakerService
{
    public function __construct(private MakerRepository $makerRepository) {}

    /**
    * @return Maker[]
    */
    public function list(?int $typeId = null): array
    {
        if (null === $typeId) {
            return $this->makerRepository->findBy([], ['id' => 'asc']);
        }

        return $this->makerRepository->findByTypeId($typeId);
    }
}
