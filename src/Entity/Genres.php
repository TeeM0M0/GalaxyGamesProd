<?php

namespace App\Entity;

use App\Repository\GenresRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GenresRepository::class)]
class Genres
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $genre = null;

    #[ORM\OneToMany(mappedBy: 'genre', targetEntity: Articles::class)]
    private Collection $articleG;

 
    public function __construct()
    {
        $this->articleG = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

   

    /**
     * @return Collection<int, Articles>
     */
    public function getArticleG(): Collection
    {
        return $this->articleG;
    }

    public function addArticleG(Articles $articleG): self
    {
        if (!$this->articleG->contains($articleG)) {
            $this->articleG->add($articleG);
            $articleG->setGenre($this);
        }

        return $this;
    }

    public function removeArticleG(Articles $articleG): self
    {
        if ($this->articleG->removeElement($articleG)) {
            // set the owning side to null (unless already changed)
            if ($articleG->getGenre() === $this) {
                $articleG->setGenre(null);
            }
        }

        return $this;
    }

   
}
