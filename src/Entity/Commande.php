<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateCmd = null;

    #[ORM\Column(length: 255)]
    private ?string $methode_livraison = null;

    #[ORM\ManyToOne(inversedBy: 'Commande')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Produit $Produit = null;

    #[ORM\Column(length: 255)]
    private ?string $ville = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCmd(): ?\DateTimeInterface
    {
        return $this->DateCmd;
    }

    public function setDateCmd(\DateTimeInterface $DateCmd): static
    {
        $this->DateCmd = $DateCmd;

        return $this;
    }

    public function getMethodeLivraison(): ?string
    {
        return $this->methode_livraison;
    }

    public function setMethodeLivraison(string $methode_livraison): static
    {
        $this->methode_livraison = $methode_livraison;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->Produit;
    }

    public function setProduit(?Produit $Produit): static
    {
        $this->Produit = $Produit;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }
}
