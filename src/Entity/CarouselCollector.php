<?php

namespace App\Entity;

use App\Repository\CarouselCollectorRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarouselCollectorRepository::class)]
class CarouselCollector
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomJeu = null;

    #[ORM\Column(length: 255)]
    private ?string $nomImage = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomJeu(): ?string
    {
        return $this->nomJeu;
    }

    public function setNomJeu(string $nomJeu): self
    {
        $this->nomJeu = $nomJeu;

        return $this;
    }

    public function getNomImage(): ?string
    {
        return $this->nomImage;
    }

    public function setNomImage(string $nomImage): self
    {
        $this->nomImage = $nomImage;

        return $this;
    }
}
