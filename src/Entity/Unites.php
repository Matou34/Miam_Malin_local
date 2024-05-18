<?php

namespace App\Entity;

use App\Repository\UnitesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


#[ORM\Entity(repositoryClass: UnitesRepository::class)]
#[UniqueEntity(fields: ['un_libelle'], message: 'Une unitée de mesure avec ce nom existe déjà.')]

class Unites
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $un_libelle = null;

    #[ORM\OneToMany(mappedBy: 'unites', targetEntity: Quantites::class)]
    private Collection $quantites;

    public function __construct()
    {
        $this->quantites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUnLibelle(): ?string
    {
        return $this->un_libelle;
    }

    public function setUnLibelle(string $un_libelle): static
    {
        $this->un_libelle = $un_libelle;

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
            $quantite->setUnites($this);
        }

        return $this;
    }

    public function removeQuantite(Quantites $quantite): static
    {
        if ($this->quantites->removeElement($quantite)) {
            // set the owning side to null (unless already changed)
            if ($quantite->getUnites() === $this) {
                $quantite->setUnites(null);
            }
        }

        return $this;
    }
}
