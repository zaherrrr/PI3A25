<?php

namespace App\Entity;

use App\Repository\CategorieFormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategorieFormationRepository::class)
 */
class CategorieFormation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\OneToMany(targetEntity="Formation",mappedBy="categorieFormation",cascade={"remove"})
     */

    private $formation;
    /**
     * @ORM\Column(type="string", length=255)
     * 
     */
    private $nom_cat_frt;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $description_cat_frt;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbr_cat_frt;

    public function __construct()
    {
        $this->formation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCatFrt(): ?string
    {
        return $this->nom_cat_frt;
    }

    public function setNomCatFrt(string $nom_cat_frt): self
    {
        $this->nom_cat_frt = $nom_cat_frt;

        return $this;
    }

    public function getDescriptionCatFrt(): ?string
    {
        return $this->description_cat_frt;
    }

    public function setDescriptionCatFrt(string $description_cat_frt): self
    {
        $this->description_cat_frt = $description_cat_frt;

        return $this;
    }

    public function getNbrCatFrt(): ?int
    {
        return $this->nbr_cat_frt;
    }

    public function setNbrCatFrt(int $nbr_cat_frt): self
    {
        $this->nbr_cat_frt = $nbr_cat_frt;

        return $this;
    }

    /**
     * @return Collection|Formation[]
     */
    public function getFormation(): Collection
    {
        return $this->formation;
    }

    public function addFormation(Formation $formation): self
    {
        if (!$this->formation->contains($formation)) {
            $this->formation[] = $formation;
            $formation->setCategorieFormation($this);
        }

        return $this;
    }

    public function removeFormation(Formation $formation): self
    {
        if ($this->formation->removeElement($formation)) {
            // set the owning side to null (unless already changed)
            if ($formation->getCategorieFormation() === $this) {
                $formation->setCategorieFormation(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nom_cat_frt;
    }
}
