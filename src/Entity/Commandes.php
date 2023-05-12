<?php

namespace App\Entity;

use App\Repository\CommandesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandesRepository::class)]
class Commandes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $User = null;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: AjoutCommandes::class, orphanRemoval: true)]
    private Collection $ajoutCommandes;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    private ?float $totalPrix = null;

    #[ORM\OneToOne(mappedBy: 'commande', cascade: ['persist', 'remove'])]
    private ?InfoCommande $infoCommande = null;

    public function __construct()
    {
        $this->ajoutCommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    /**
     * @return Collection<int, AjoutCommandes>
     */
    public function getAjoutCommandes(): Collection
    {
        return $this->ajoutCommandes;
    }

    public function addAjoutCommande(AjoutCommandes $ajoutCommande): self
    {
        if (!$this->ajoutCommandes->contains($ajoutCommande)) {
            $this->ajoutCommandes->add($ajoutCommande);
            $ajoutCommande->setCommande($this);
        }

        return $this;
    }

    public function removeAjoutCommande(AjoutCommandes $ajoutCommande): self
    {
        if ($this->ajoutCommandes->removeElement($ajoutCommande)) {
            // set the owning side to null (unless already changed)
            if ($ajoutCommande->getCommande() === $this) {
                $ajoutCommande->setCommande(null);
            }
        }

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTotalPrix(): ?float
    {
        return $this->totalPrix;
    }

    public function setTotalPrix(float $totalPrix): self
    {
        $this->totalPrix = $totalPrix;

        return $this;
    }

    public function getInfoCommande(): ?InfoCommande
    {
        return $this->infoCommande;
    }

    public function setInfoCommande(InfoCommande $infoCommande): self
    {
        // set the owning side of the relation if necessary
        if ($infoCommande->getCommande() !== $this) {
            $infoCommande->setCommande($this);
        }

        $this->infoCommande = $infoCommande;

        return $this;
    }

}
