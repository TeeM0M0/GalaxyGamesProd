<?php

namespace App\Entity;

use App\Repository\PlatformeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlatformeRepository::class)]
class Platforme
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $platforme = null;

    #[ORM\OneToMany(mappedBy: 'platforme', targetEntity: Articles::class)]
    private Collection $articles;

    
    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlatforme(): ?string
    {
        return $this->platforme;
    }

    public function setPlatforme(string $platforme): self
    {
        $this->platforme = $platforme;

        return $this;
    }

    /**
     * @return Collection<int, Articles>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Articles $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles->add($article);
            $article->setPlatforme($this);
        }

        return $this;
    }

    public function removeArticle(Articles $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getPlatforme() === $this) {
                $article->setPlatforme(null);
            }
        }

        return $this;
    }

    
}
