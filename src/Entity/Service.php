<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
#[Vich\Uploadable]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @Assert\NotBlank(message="This field should not be blank.")
     * @Assert\Length(
     * min=5,
     * minMessage="exemple"
     * )
     * @ORM\Column(type="string",length=255)
     */
    #[ORM\Column(length: 255)]
     private ?string $nameS = null;

    /**
     * @Assert\NotBlank(message="You should enter the service description.")
     * @Assert\Length(
     * min=5,
     * minMessage="exemple"
     * )
     * @ORM\Column(type="string",length=255)
     */
    #[ORM\Column(length: 255)]
    private ?string $descriptionS = null;



    #[ORM\Column(length: 255)]
    private ?string $localisation = null;

    /**
     * @Assert\NotBlank(message="Service's state is missing!")
     * @Assert\Length(
     * min=5,
     * minMessage="exemple"
     * )
     * @ORM\Column(type="string",length=255)
     */
    #[ORM\Column(length: 255)]
    private ?string $state = null;

    /**
     * @Assert\NotBlank(message="This field should not be blank.")
     * @Assert\Length(
     * min=5,
     * minMessage="exemple"
     * )
     * @ORM\Column(type="string",length=255)
     */
    #[ORM\Column(length: 255)]
    private ?string $dispoDate = null;

    
    #[Vich\UploadableField(mapping: 'services', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null; 



    #[ORM\ManyToOne(inversedBy: 'services')]
    private ?CategorieService $categorie = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameS(): ?string
    {
        return $this->nameS;
    }

    public function setNameS(string $nameS): static
    {
        $this->nameS = $nameS;

        return $this;
    }

    public function getDescriptionS(): ?string
    {
        return $this->descriptionS;
    }

    public function setDescriptionS(string $descriptionS): static
    {
        $this->descriptionS = $descriptionS;

        return $this;
    }



    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(string $localisation): static
    {
        $this->localisation = $localisation;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): static
    {
        $this->state = $state;

        return $this;
    }

    public function getDispoDate(): ?string
    {
        return $this->dispoDate;
    }

    public function setDispoDate(string $dispoDate): static
    {
        $this->dispoDate = $dispoDate;

        return $this;
    }

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

    public function getCategorie(): ?CategorieService
    {
        return $this->categorie;
    }

    public function setCategorie(?CategorieService $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }
    
}
