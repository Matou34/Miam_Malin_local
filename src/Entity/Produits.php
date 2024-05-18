<?php

namespace App\Entity;

use App\Repository\ProduitsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


#[ORM\Entity(repositoryClass: ProduitsRepository::class)]
#[UniqueEntity(fields: ['PR_LIBELLE'], message: 'Un ingrédient avec ce nom existe déjà.')]
class Produits
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $PR_LIBELLE = null;

    #[ORM\ManyToOne(inversedBy: 'produits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categories $categorie = null;

    #[ORM\OneToMany(mappedBy: 'produits', targetEntity: Quantites::class)]
    private Collection $quantites;

    public function __construct()
    {
        $this->quantites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPRLIBELLE(): ?string
    {
        return $this->PR_LIBELLE;
    }

    public function setPRLIBELLE(string $PR_LIBELLE): static
    {
        $this->PR_LIBELLE = $PR_LIBELLE;

        return $this;
    }

    public function getCategorie(): ?Categories
    {
        return $this->categorie;
    }

    public function setCategorie(?Categories $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection<int, Quantites>
     */
    public function getQuantites(): Collection
    {
        return $this->quantites;
    }

    public function addQuantite(Quantites $quantite): static
    {
        if (!$this->quantites->contains($quantite)) {
            $this->quantites->add($quantite);
            $quantite->setProduits($this);
        }

        return $this;
    }

    public function removeQuantite(Quantites $quantite): static
    {
        if ($this->quantites->removeElement($quantite)) {
            // set the owning side to null (unless already changed)
            if ($quantite->getProduits() === $this) {
                $quantite->setProduits(null);
            }
        }

        return $this;
    }
}
