<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $libelle;

    #[ORM\Column(type: 'integer')]
    private $stock;

    #[ORM\ManyToOne(targetEntity: Categorie::class)]
    private $categorie;
    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: Entree::class)]
    private $entree;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: Sortie::class)]
    private $sortie;


    public function __construct()
    {
       
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

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }
    public function getEntree(): ?Entree
    {
        return $this->entree;
    }
    public function setEntree(?Entree $entree): self
    {
        $this->entree = $entree;

        return $this;
    }
    public function getSortie(): ?Sortie
    {
        return $this->sortie;
    }
    public function setSortie(?Sortie $sortie): self
    {
        $this->sortie = $sortie;

        return $this;
    }
    public function __toString()
    {
        return $this->libelle;
    }
}
