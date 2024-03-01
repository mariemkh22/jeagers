<?php

namespace App\Entity;

use App\Repository\CategorieServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieServiceRepository::class)]
class CategorieService
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nameC = null;

    #[ORM\Column(length: 255)]
    private ?string $descriptionC = null;

    #[ORM\OneToMany(mappedBy: 'categorie', targetEntity: Service::class)]
    private Collection $services;

    public function __construct()
    {
        $this->services = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameC(): ?string
    {
        return $this->nameC;
    }

    public function setNameC(string $nameC): static
    {
        $this->nameC = $nameC;

        return $this;
    }

    public function getDescriptionC(): ?string
    {
        return $this->descriptionC;
    }

    public function setDescriptionC(string $descriptionC): static
    {
        $this->descriptionC = $descriptionC;

        return $this;
    }

    /**
     * @return Collection<int, Service>
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(Service $service): static
    {
        if (!$this->services->contains($service)) {
            $this->services->add($service);
            $service->setCategorie($this);
        }

        return $this;
    }

    public function removeService(Service $service): static
    {
        if ($this->services->removeElement($service)) {
            // set the owning side to null (unless already changed)
            if ($service->getCategorie() === $this) {
                $service->setCategorie(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->id;
    }

    
}
