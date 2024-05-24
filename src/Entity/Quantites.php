<?php

namespace App\Entity;

use App\Repository\QuantitesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuantitesRepository::class)]
class Quantites
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[ORM\JoinColumn(nullable: true)]
    private ?int $qu_quantites = null;

    #[ORM\ManyToOne(inversedBy: 'quantites')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Unites $unites = null;

    #[ORM\ManyToOne(inversedBy: 'quantites')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Etapes $etapes = null;

    #[ORM\ManyToOne(inversedBy: 'quantites')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Produits $produits = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuQuantites(): ?int
    {
        return $this->qu_quantites;
    }

    public function setQuQuantites(int $qu_quantites): static
    {
        $this->qu_quantites = $qu_quantites;

        return $this;
    }

    public function getUnites(): ?Unites
    {
        return $this->unites;
    }

    public function setUnites(?Unites $unites): static
    {
        $this->unites = $unites;

        return $this;
    }

    public function getEtapes(): ?Etapes
    {
        return $this->etapes;
    }

    public function setEtapes(?Etapes $etapes): static
    {
        $this->etapes = $etapes;

        return $this;
    }

    public function getProduits(): ?Produits
    {
        return $this->produits;
    }

    public function setProduits(?Produits $produits): static
    {
        $this->produits = $produits;

        return $this;
    }
}
