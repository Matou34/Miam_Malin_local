<?php

namespace App\Entity;

use App\Repository\EtapesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtapesRepository::class)]
class Etapes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $et_numero = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $et_description = null;

    #[ORM\OneToMany(mappedBy: 'etapes', targetEntity: Quantites::class, cascade: ["remove"])]
    private Collection $quantites;

    #[ORM\ManyToOne(inversedBy: 'etapes')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Cuisson $cuisson = null;

    #[ORM\ManyToOne(inversedBy: 'etapes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Recettes $recette = null;

    public function __construct()
    {
        $this->quantites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtNumero(): ?int
    {
        return $this->et_numero;
    }

    public function setEtNumero(int $et_numero): static
    {
        $this->et_numero = $et_numero;

        return $this;
    }

    public function getEtDescription(): ?string
    {
        return $this->et_description;
    }

    public function setEtDescription(string $et_description): static
    {
        $this->et_description = $et_description;

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
            $quantite->setEtapes($this);
        }

        return $this;
    }

    public function removeQuantite(Quantites $quantite): static
    {
        if ($this->quantites->removeElement($quantite)) {
            // set the owning side to null (unless already changed)
            if ($quantite->getEtapes() === $this) {
                $quantite->setEtapes(null);
            }
        }

        return $this;
    }

    public function getCuisson(): ?Cuisson
    {
        return $this->cuisson;
    }

    public function setCuisson(?Cuisson $cuisson): static
    {
        $this->cuisson = $cuisson;

        return $this;
    }

    public function getRecette(): ?Recettes
    {
        return $this->recette;
    }

    public function setRecette(?Recettes $recette): static
    {
        $this->recette = $recette;

        return $this;
    }
}
