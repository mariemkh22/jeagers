<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\LocalisationGeographiqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocalisationGeographiqueRepository::class)]
class LocalisationGeographique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    /**
     * @Assert\NotBlank(message="Le champ région ne peut pas être vide")
     * @Assert\Choice(choices={"Kebili", "Tunis", "Nabeul", "Gabes", "Mounistir"}, message="Veuillez sélectionner une région valide")
     */
    #[ORM\Column(length: 255)]
    private ?string $region = null;

  /**
     * @ORM\Column(type="int")
     * @Assert\NotBlank(message="Le champ code postal ne peut pas être vide")
     * @Assert\Type(type="int", message="La valeur doit être un nombre ")
     */

    #[ORM\Column]
    private ?int $codepostal = null;


      /** 
  * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="L'adresse ne peut pas être vide")
     * @Assert\Length(
      *     max=255,
       *   maxMessage="La description ne peut pas dépasser {{ limit }} caractères"
      *)
     */

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\OneToMany(mappedBy: 'LocalisationGeographique', targetEntity: Livraison::class)]
    private Collection $Livraison;

    public function __construct()
    {
        $this->Livraison = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): static
    {
        $this->region = $region;

        return $this;
    }

    public function getCodepostal(): ?int
    {
        return $this->codepostal;
    }

    public function setCodepostal(int $codepostal): static
    {
        $this->codepostal = $codepostal;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * @return Collection<int, Livraison>
     */
    public function getLivraison(): Collection
    {
        return $this->Livraison;
    }

    public function addLivraison(Livraison $livraison): static
    {
        if (!$this->Livraison->contains($livraison)) {
            $this->Livraison->add($livraison);
            $livraison->setLocalisationGeographique($this);
        }

        return $this;
    }

    public function removeLivraison(Livraison $livraison): static
    {
        if ($this->Livraison->removeElement($livraison)) {
            // set the owning side to null (unless already changed)
            if ($livraison->getLocalisationGeographique() === $this) {
                $livraison->setLocalisationGeographique(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->id;
    }
}
