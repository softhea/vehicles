<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\VehicleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: VehicleRepository::class)]
#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => 'api']),
        new GetCollection(normalizationContext: ['groups' => 'api'])
    ],
    order: ['id' => 'DESC'],
    paginationEnabled: false,
)]
class Vehicle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['api'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['api'])]
    private ?string $model = null;

    // #[ORM\ManyToOne(inversedBy: 'vehicles', fetch: 'EAGER')]
    #[ORM\ManyToOne(inversedBy: 'vehicles')]
    #[Groups(['api'])]
    private ?Type $type = null;

    #[ORM\ManyToOne(inversedBy: 'vehicles')]
    #[Groups(['api'])]
    private ?Maker $maker = null;

    #[ORM\OneToMany(targetEntity: VehicleProperty::class, mappedBy: 'vehicle', cascade: ['persist', 'remove'])]
    #[Groups(['api'])]
    private Collection $properties;

    public function __construct()
    {
        $this->properties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getMaker(): ?Maker
    {
        return $this->maker;
    }

    public function setMaker(?Maker $maker): static
    {
        $this->maker = $maker;

        return $this;
    }

    /**
     * @return Collection<int, Property>
     */
    public function getProperties(): Collection
    {
        return $this->properties;
    }

    public function addProperty(Property $property): static
    {
        if (!$this->properties->contains($property)) {
            $this->properties->add($property);
            $property->addVehicle($this);
        }

        return $this;
    }

    public function removeProperty(Property $property): static
    {
        if ($this->properties->removeElement($property)) {
            $property->removeVehicle($this);
        }

        return $this;
    }
}
