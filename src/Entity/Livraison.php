<?php

namespace App\Entity;

use App\Repository\LivraisonRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: LivraisonRepository::class)]
class Livraison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateDebut = null;
    
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateFin = null;
    
    /**
    * @ORM\Column(type="string", length=255)
    * @Assert\NotBlank(message="L'entreprise' ne peut pas être vide")
    * @Assert\Length(max=255, maxMessage="Le nom du produit ne peut pas dépasser {{ limit }} caractères")
    */
    #[ORM\Column(length: 255)]
    private ?string $entreprise = null;
    
     /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="Le champ fees ne peut pas être vide")
     * @Assert\Type(type="int", message="La valeur doit être un nombre décimal")
     */
    #[ORM\Column]
    private ?int $frais = null;

    /**
    * @ORM\Column(type="string", length=255)
    * @Assert\NotBlank(message="La status ne peut pas être vide")
    * @Assert\Length(max=255, maxMessage="Le nom du status ne peut pas dépasser {{ limit }} caractères")
    */
    #[ORM\Column(length: 255)]
    private ?string $status = null;
 
    #[ORM\ManyToOne(inversedBy: 'Livraison')]
    #[ORM\JoinColumn(nullable: false)] 
    private ?LocalisationGeographique $localisationGeographique ;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(?int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->DateDebut;
    }

    public function setDateDebut(\DateTimeInterface $DateDebut): static
    {
        $this->DateDebut = $DateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->DateFin;
    }

    public function setDateFin(\DateTimeInterface $DateFin): static
    {
        $this->DateFin = $DateFin;

        return $this;
    }

    public function getEntreprise(): ?string
    {
        return $this->entreprise;
    }

    public function setEntreprise(string $entreprise): static
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    public function getFrais(): ?int
    {
        return $this->frais;
    }

    public function setFrais(int $frais): static
    {
        $this->frais = $frais;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getLocalisationGeographique(): ?LocalisationGeographique
    {
        return $this->localisationGeographique;
    }

    public function setLocalisationGeographique(?LocalisationGeographique $localisationGeographique): static
    {
        $this->localisationGeographique = $localisationGeographique;

        return $this;
    }
}
