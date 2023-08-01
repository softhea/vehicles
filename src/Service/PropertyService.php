<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;

class PropertyService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private PropertyRepository $propertyRepository
    ) {}

    public function findOrCreate(string $name, bool $persist = true): Property
    {
        $property = $this->propertyRepository->findOneBy(['name' => $name]);
        if (null !== $property) {
            return $property;
        }

        $property = new Property();
        $property->setName($name);

        $this->entityManager->persist($property);

        if ($persist) {
            $this->entityManager->flush();
        }

        return $property;
    }
}
