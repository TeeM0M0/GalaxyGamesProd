<?php

namespace App\Entity;

use App\Repository\ArticlesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticlesRepository::class)]
class Articles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $libelle = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 50)]
    private ?string $editeur = null;

    #[ORM\Column(length: 50)]
    private ?string $dev = null;

    #[ORM\Column]
    private ?int $qteStock = null;

    #[ORM\Column]
    private ?int $qteVendu = null;

    #[ORM\OneToMany(mappedBy: 'article', targetEntity: ImageArticle::class, orphanRemoval: true )]
    private Collection $imageArticles;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateSortie = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ClasseAge $classeAge = null;

    #[ORM\ManyToOne(inversedBy: 'articleG')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Genres $genre = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Platforme $platforme = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'Favoris')]
    private Collection $users;

    #[ORM\OneToMany(mappedBy: 'article', targetEntity: Ajouter::class)]
    private Collection $ajouters;

    #[ORM\ManyToMany(targetEntity: Langues::class, inversedBy: 'articles')]
    private Collection $langue;

    #[ORM\OneToMany(mappedBy: 'article', targetEntity: AjoutCommandes::class)]
    private Collection $ajoutCommandes;


    public function __construct()
    {
        $this->imageArticles = new ArrayCollection();
        $this->classeAges = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->ajouters = new ArrayCollection();
        $this->langue = new ArrayCollection();
        $this->ajoutCommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getEditeur(): ?string
    {
        return $this->editeur;
    }

    public function setEditeur(string $editeur): self
    {
        $this->editeur = $editeur;

        return $this;
    }

    public function getDev(): ?string
    {
        return $this->dev;
    }

    public function setDev(string $dev): self
    {
        $this->dev = $dev;

        return $this;
    }

    public function getQteStock(): ?int
    {
        return $this->qteStock;
    }

    public function setQteStock(int $qteStock): self
    {
        $this->qteStock = $qteStock;

        return $this;
    }

    public function getQteVendu(): ?int
    {
        return $this->qteVendu;
    }

    public function setQteVendu(int $qteVendu): self
    {
        $this->qteVendu = $qteVendu;

        return $this;
    }


    /**
     * @return Collection<int, ImageArticle>
     */
    public function getImageArticles(): Collection
    {
        return $this->imageArticles;
    }

    public function addImageArticle(ImageArticle $imageArticle): self
    {
        if (!$this->imageArticles->contains($imageArticle)) {
            $this->imageArticles->add($imageArticle);
            $imageArticle->setArticle($this);
        }

        return $this;
    }

    public function removeImageArticle(ImageArticle $imageArticle): self
    {
        if ($this->imageArticles->removeElement($imageArticle)) {
            // set the owning side to null (unless already changed)
            if ($imageArticle->getArticle() === $this) {
                $imageArticle->setArticle(null);
            }
        }

        return $this;
    }

    public function getDateSortie(): ?\DateTimeInterface
    {
        return $this->dateSortie;
    }

    public function setDateSortie(\DateTimeInterface $dateSortie): self
    {
        $this->dateSortie = $dateSortie;

        return $this;
    }


    public function getClasseAge(): ?ClasseAge
    {
        return $this->classeAge;
    }

    public function setClasseAge(?ClasseAge $classeAge): self
    {
        $this->classeAge = $classeAge;

        return $this;
    }

    public function getGenre(): ?Genres
    {
        return $this->genre;
    }

    public function setGenre(?Genres $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getPlatforme(): ?Platforme
    {
        return $this->platforme;
    }

    public function setPlatforme(?Platforme $platforme): self
    {
        $this->platforme = $platforme;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addFavori($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeFavori($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Ajouter>
     */
    public function getAjouters(): Collection
    {
        return $this->ajouters;
    }

    public function addAjouter(Ajouter $ajouter): self
    {
        if (!$this->ajouters->contains($ajouter)) {
            $this->ajouters->add($ajouter);
            $ajouter->setArticle($this);
        }

        return $this;
    }

    public function removeAjouter(Ajouter $ajouter): self
    {
        if ($this->ajouters->removeElement($ajouter)) {
            // set the owning side to null (unless already changed)
            if ($ajouter->getArticle() === $this) {
                $ajouter->setArticle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Langues>
     */
    public function getLangue(): Collection
    {
        return $this->langue;
    }

    public function addLangue(Langues $langue): self
    {
        if (!$this->langue->contains($langue)) {
            $this->langue->add($langue);
        }

        return $this;
    }

    public function removeLangue(Langues $langue): self
    {
        $this->langue->removeElement($langue);

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
            $ajoutCommande->setArticle($this);
        }

        return $this;
    }

    public function removeAjoutCommande(AjoutCommandes $ajoutCommande): self
    {
        if ($this->ajoutCommandes->removeElement($ajoutCommande)) {
            // set the owning side to null (unless already changed)
            if ($ajoutCommande->getArticle() === $this) {
                $ajoutCommande->setArticle(null);
            }
        }

        return $this;
    }



}
