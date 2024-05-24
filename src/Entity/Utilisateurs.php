<?php

namespace App\Entity;

use App\Repository\UtilisateursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UtilisateursRepository::class)]
class Utilisateurs
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $ut_surnom = null;

    #[ORM\Column(length: 255)]
    private ?string $ut_prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $ut_nom = null;

    #[ORM\Column(length: 255)]
    private ?string $ut_email = null;

    #[ORM\Column(length: 255)]
    private ?string $ut_password = null;

    #[ORM\ManyToMany(targetEntity: Recettes::class, mappedBy: 'recettes_utilisateurs')]
    private Collection $recettes;

    #[ORM\ManyToOne(inversedBy: 'utilisateurs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Roles $roles = null;

    public function __construct()
    {
        $this->recettes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUtSurnom(): ?string
    {
        return $this->ut_surnom;
    }

    public function setUtSurnom(string $ut_surnom): static
    {
        $this->ut_surnom = $ut_surnom;

        return $this;
    }

    public function getUtPrenom(): ?string
    {
        return $this->ut_prenom;
    }

    public function setUtPrenom(string $ut_prenom): static
    {
        $this->ut_prenom = $ut_prenom;

        return $this;
    }

    public function getUtNom(): ?string
    {
        return $this->ut_nom;
    }

    public function setUtNom(string $ut_nom): static
    {
        $this->ut_nom = $ut_nom;

        return $this;
    }

    public function getUtEmail(): ?string
    {
        return $this->ut_email;
    }

    public function setUtEmail(string $ut_email): static
    {
        $this->ut_email = $ut_email;

        return $this;
    }

    public function getUtPassword(): ?string
    {
        return $this->ut_password;
    }

    public function setUtPassword(string $ut_password): static
    {
        $this->ut_password = $ut_password;

        return $this;
    }

    /**
     * @return Collection<int, Recettes>
     */
    public function getRecettes(): Collection
    {
        return $this->recettes;
    }

    public function addRecette(Recettes $recette): static
    {
        if (!$this->recettes->contains($recette)) {
            $this->recettes->add($recette);
            $recette->addRecettesUtilisateur($this);
        }

        return $this;
    }

    public function removeRecette(Recettes $recette): static
    {
        if ($this->recettes->removeElement($recette)) {
            $recette->removeRecettesUtilisateur($this);
        }

        return $this;
    }

    public function getRoles(): ?Roles
    {
        return $this->roles;
    }

    public function setRoles(?Roles $roles): static
    {
        $this->roles = $roles;

        return $this;
    }
}
