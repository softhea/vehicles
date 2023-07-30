<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\VehiclePropertyRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: VehiclePropertyRepository::class)]
#[UniqueConstraint(name: "unique_vehicle_property", columns: ["vehicle_id", "property_id"])]
#[ApiResource]
class VehicleProperty
{
    public const MAX_PROPERTIES_PER_VEHICLE = 7;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Vehicle::class, cascade: ['persist', 'remove'], fetch: 'LAZY')]
    #[ORM\JoinColumn(name: 'vehicle_id', referencedColumnName: 'id', nullable: false)]
    private Vehicle $vehicle;

    #[ORM\ManyToOne(targetEntity: Property::class, cascade: ['persist', 'remove'], fetch: 'LAZY')]
    #[ORM\JoinColumn(name: 'property_id', referencedColumnName: 'id', nullable: false)]
    private Property $property;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $value = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    #[Groups(['api'])]
    public function getName(): ?string 
    {
        return $this->property->getName();
    }

    public function getVehicle(): Vehicle
    {
        return $this->vehicle;
    }

    public function setVehicle(Vehicle $vehicle): static
    {
        $this->vehicle = $vehicle;

        return $this;
    }

    public function getProperty(): Property
    {
        return $this->property;
    }

    public function setProperty(Property $property): static
    {
        $this->property = $property;

        return $this;
    }

    #[Groups(['api'])]
    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): static
    {
        $this->value = $value;

        return $this;
    }
}
