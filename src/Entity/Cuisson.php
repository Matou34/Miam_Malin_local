<?php

namespace App\Entity;

use App\Repository\CuissonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: CuissonRepository::class)]
#[UniqueEntity(fields: ['cu_libelle'], message: 'Un mode de cuisson avec ce nom existe déjà.')]
class Cuisson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $cu_libelle = null;

    #[ORM\OneToMany(mappedBy: 'cuisson', targetEntity: Etapes::class)]
    private Collection $etapes;

    public function __construct()
    {
        $this->etapes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCuLibelle(): ?string
    {
        return $this->cu_libelle;
    }

    public function setCuLibelle(string $cu_libelle): static
    {
        $this->cu_libelle = $cu_libelle;

        return $this;
    }

    /**
     * @return Collection<int, Etapes>
     */
    public function getEtapes(): Collection
    {
        return $this->etapes;
    }

    public function addEtape(Etapes $etape): static
    {
        if (!$this->etapes->contains($etape)) {
            $this->etapes->add($etape);
            $etape->setCuisson($this);
        }

        return $this;
    }

    public function removeEtape(Etapes $etape): static
    {
        if ($this->etapes->removeElement($etape)) {
            // set the owning side to null (unless already changed)
            if ($etape->getCuisson() === $this) {
                $etape->setCuisson(null);
            }
        }

        return $this;
    }
}
