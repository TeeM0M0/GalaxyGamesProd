<?php

namespace App\Entity;

use App\Repository\ClasseAgeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClasseAgeRepository::class)]
class ClasseAge
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    private ?string $PEGI = null;

    #[ORM\OneToMany(mappedBy: 'classeAge', targetEntity: Articles::class)]
    private Collection $articles;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPEGI(): ?string
    {
        return $this->PEGI;
    }

    public function setPEGI(string $PEGI): self
    {
        $this->PEGI = $PEGI;

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
            $article->setClasseAge($this);
        }

        return $this;
    }

    public function removeArticle(Articles $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getClasseAge() === $this) {
                $article->setClasseAge(null);
            }
        }

        return $this;
    }
}
