<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\VehiclePropertyRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VehiclePropertyRepository::class)]
#[ApiResource]
class VehicleProperty
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Vehicle::class, cascade: ['persist', 'remove'], fetch: 'LAZY')]
    #[ORM\JoinColumn(name: 'vehicle_id', referencedColumnName: 'id')]
    private Vehicle $vehicle;

    #[ORM\ManyToOne(targetEntity: Property::class, cascade: ['persist', 'remove'], fetch: 'LAZY')]
    #[ORM\JoinColumn(name: 'property_id', referencedColumnName: 'id')]
    private Property $property;

    #[ORM\Column(length: 50)]
    private ?string $value = null;

    public function getId(): ?int
    {
        return $this->id;
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
