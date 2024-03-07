<?php

namespace App\Entity;

use App\Repository\MessagerieRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessagerieRepository::class)]
class Messagerie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $DateEnvoie = null;

    #[ORM\Column(length: 255)]
    private ?string $Contenue = null;

    #[ORM\Column(length: 255)]
    private ?string $DateReception = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $CreatedAt = null;

    #[ORM\Column]
    private ?bool $IsRead = null;

    #[ORM\ManyToOne(inversedBy: 'messageries')]
    private ?User $sender = null;

    #[ORM\ManyToOne(inversedBy: 'received')]
    private ?User $recipient = null;

    public function __construct()
    {   
        $this->CreatedAt = new \DateTime();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateEnvoie(): ?string
    {
        return $this->DateEnvoie;
    }

    public function setDateEnvoie(string $DateEnvoie): static
    {
        $this->DateEnvoie = $DateEnvoie;

        return $this;
    }

    public function getContenue(): ?string
    {
        return $this->Contenue;
    }

    public function setContenue(string $Contenue): static
    {
        $this->Contenue = $Contenue;

        return $this;
    }

    public function getDateReception(): ?string
    {
        return $this->DateReception;
    }

    public function setDateReception(string $DateReception): static
    {
        $this->DateReception = $DateReception;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(\DateTimeInterface $CreatedAt): static
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }

    public function isIsRead(): ?bool
    {
        return $this->IsRead;
    }

    public function setIsRead(bool $IsRead): static
    {
        $this->IsRead = $IsRead;

        return $this;
    }

    public function getSender(): ?User
    {
        return $this->sender;
    }

    public function setSender(?User $sender): static
    {
        $this->sender = $sender;

        return $this;
    }

    public function getRecipient(): ?User
    {
        return $this->recipient;
    }

    public function setRecipient(?User $recipient): static
    {
        $this->recipient = $recipient;

        return $this;
    }
}
