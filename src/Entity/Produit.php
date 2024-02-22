<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;




   /**
 * @ORM\Column(type="string", length=255)
 * @Assert\NotBlank(message="Le nom du produit ne peut pas être vide")
 * @Assert\Length(max=255, maxMessage="Le nom du produit ne peut pas dépasser {{ limit }} caractères")
 */
    #[ORM\Column(length: 255)]
    private ?string $nom_produit = null;



    #[ORM\Column(length: 255)]
    private ?string $type = null;

   /** 
  * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="La description ne peut pas être vide")
     * @Assert\Length(
      *     max=255,
       *   maxMessage="La description ne peut pas dépasser {{ limit }} caractères"
      *)
     */

    

    #[ORM\Column(length: 255)]
    private ?string $description = null;


 /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="Le champ équivalent ne peut pas être vide")
     * @Assert\Type(type="float", message="La valeur doit être un nombre décimal")
     */
    #[ORM\Column]
    private ?float $equiv = null;

   
#[ORM\OneToMany(mappedBy: 'Produit', targetEntity: Commande::class, cascade:["all"],orphanRemoval:true)]

    private Collection $Commande;

    public function __construct()
    {
        $this->Commande = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomProduit(): ?string
    {
        return $this->nom_produit;
    }

    public function setNomProduit(string $nom_produit): static
    {
        $this->nom_produit = $nom_produit;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getEquiv(): ?float
    {
        return $this->equiv;
    }

    public function setEquiv(float $equiv): static
    {
        $this->equiv = $equiv;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommande(): Collection
    {
        return $this->Commande;
    }

    public function addCommande(Commande $commande): static
    {
        if (!$this->Commande->contains($commande)) {
            $this->Commande->add($commande);
            $commande->setProduit($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): static
    {
        if ($this->Commande->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getProduit() === $this) {
                $commande->setProduit(null);
            }
        }

        return $this;
    }


    public function __toString()
    {
        return $this->id;
    } 
}
