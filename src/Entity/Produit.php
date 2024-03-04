<?php

namespace App\Entity;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[Vich\Uploadable]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;




   /**
 * @ORM\Column(type="string", length=255)
 * @Assert\NotBlank(message=" Product Name can't be empty!")
 * @Assert\Length(max=255, maxMessage="Le nom du produit ne peut pas dépasser {{ limit }} caractères")
 */
    #[ORM\Column(length: 255)]
    private ?string $nom_produit = null;



    #[ORM\Column(length: 255)]
    private ?string $type = null;

   /** 
  * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message=" Description cannot be empty!")
     * @Assert\Length(
      *     max=255,
       *   maxMessage="La description ne peut pas dépasser {{ limit }} caractères"
      *)
     */

    

    #[ORM\Column(length: 255)]
    private ?string $description = null;


  /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="Equivalent Price cannot be empty!")
     * @Assert\Regex(
     *     pattern="/^[+-]?\d+(\.\d+)?$/",
     *     message="Equivalent Price must be a valid float value"
     * )
     */
    
    #[ORM\Column]
    private ?float $equiv = null;

    #[Vich\UploadableField(mapping: 'products_images', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

   
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
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
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
