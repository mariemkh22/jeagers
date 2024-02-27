<?php

namespace App\Entity;

use App\Repository\NotificationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: NotificationRepository::class)]
class Notification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $DateEnvoie = null;

    /**
     * @Assert\NotBlank(message="Subject is needed.")
     */
    #[ORM\Column(length: 255)]
    private ?string $sujet = null;

    /**
     * @Assert\NotBlank(message="You need to write.")
     */
    #[ORM\Column(length: 255)]
    private ?string $contenue = null;

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

    public function getSujet(): ?string
    {
        return $this->sujet;
    }

    public function setSujet(string $sujet): static
    {
        $this->sujet = $sujet;

        return $this;
    }

    public function getContenue(): ?string
    {
        return $this->contenue;
    }

    public function setContenue(string $contenue): static
    {
        $this->contenue = $contenue;

        return $this;
    }
}
