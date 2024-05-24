<?php

namespace App\Entity;

use App\Repository\RecettesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


#[ORM\Entity(repositoryClass: RecettesRepository::class)]
#[UniqueEntity(fields: ['re_libelle'], message: 'Une recette avec ce nom existe déjà.')]
#[Vich\Uploadable]
class Recettes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $re_libelle = null;

    #[Vich\UploadableField(mapping: 'recettes_images', fileNameProperty: 're_image')]   
    private ?File $imageFile = null;
    
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $re_image = null;

    #[ORM\Column(nullable: true)]
    private ?int $re_nb_personnes = null;

    #[ORM\Column(nullable: true)]
    private ?int $re_temps = null;

    #[ORM\Column(nullable: true)]
    private ?int $re_kcal = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $re_commentaires = null;

    #[ORM\ManyToOne(inversedBy: 'recettes')]
    private ?Regions $regions = null;

    #[ORM\OneToMany(mappedBy: 'recette', targetEntity: Etapes::class, cascade: ["remove"])]
    #[ORM\OrderBy(['et_numero' => 'ASC'])]
    private Collection $etapes;

    #[ORM\ManyToMany(targetEntity: Tags::class, inversedBy: 'recettes')]
    private Collection $recette_tags;

    #[ORM\ManyToMany(targetEntity: Utilisateurs::class, inversedBy: 'recettes')]
    private Collection $recettes_utilisateurs;

    public function __construct()
    {
        $this->etapes = new ArrayCollection();
        $this->recette_tags = new ArrayCollection();
        $this->recettes_utilisateurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReLibelle(): ?string
    {
        return $this->re_libelle;
    }

    public function setReLibelle(string $re_libelle): static
    {
        $this->re_libelle = $re_libelle;

        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile = null): self
    {
        $this->imageFile = $imageFile;

        return $this;
    }

    public function getReImage(): ?string
    {
        return $this->re_image;
    }

    public function setReImage(?string $re_image): static
    {
        $this->re_image = $re_image;

        return $this;
    }

    public function getReNbPersonnes(): ?int
    {
        return $this->re_nb_personnes;
    }

    public function setReNbPersonnes(int $re_nb_personnes): static
    {
        $this->re_nb_personnes = $re_nb_personnes;

        return $this;
    }

    public function getReTemps(): ?int
    {
        return $this->re_temps;
    }

    public function setReTemps(?int $re_temps): static
    {
        $this->re_temps = $re_temps;

        return $this;
    }

    public function getReKcal(): ?int
    {
        return $this->re_kcal;
    }

    public function setReKcal(?int $re_kcal): static
    {
        $this->re_kcal = $re_kcal;

        return $this;
    }

    public function getReCommentaires(): ?string
    {
        return $this->re_commentaires;
    }

    public function setReCommentaires(?string $re_commentaires): static
    {
        $this->re_commentaires = $re_commentaires;

        return $this;
    }

    public function getRegions(): ?Regions
    {
        return $this->regions;
    }

    public function setRegions(?Regions $regions): static
    {
        $this->regions = $regions;

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
            $etape->setRecette($this);
        }

        return $this;
    }

    public function removeEtape(Etapes $etape): static
    {
        if ($this->etapes->removeElement($etape)) {
            // set the owning side to null (unless already changed)
            if ($etape->getRecette() === $this) {
                $etape->setRecette(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Tags>
     */
    public function getRecetteTags(): Collection
    {
        return $this->recette_tags;
    }

    public function addRecetteTag(Tags $recetteTag): static
    {
        if (!$this->recette_tags->contains($recetteTag)) {
            $this->recette_tags->add($recetteTag);
        }

        return $this;
    }

    public function removeRecetteTag(Tags $recetteTag): static
    {
        $this->recette_tags->removeElement($recetteTag);

        return $this;
    }

    /**
     * @return Collection<int, Utilisateurs>
     */
    public function getRecettesUtilisateurs(): Collection
    {
        return $this->recettes_utilisateurs;
    }

    public function addRecettesUtilisateur(Utilisateurs $recettesUtilisateur): static
    {
        if (!$this->recettes_utilisateurs->contains($recettesUtilisateur)) {
            $this->recettes_utilisateurs->add($recettesUtilisateur);
        }

        return $this;
    }

    public function removeRecettesUtilisateur(Utilisateurs $recettesUtilisateur): static
    {
        $this->recettes_utilisateurs->removeElement($recettesUtilisateur);

        return $this;
    }
}
