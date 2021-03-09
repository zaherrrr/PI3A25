<?php

namespace App\Entity;

use App\Repository\CategorieEmploiRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategorieEmploiRepository::class)
 */
class CategorieEmploi
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomEmploi;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descriptionEmploi;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbrOffres;
    /**
     * @ORM\OneToMany(targetEntity="OffreEmploi" , mappedBy="categorieEmploi")
     */

    private $offre;

    public function __construct()
    {
        $this->offre = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEmploi(): ?string
    {
        return $this->nomEmploi;
    }

    public function setNomEmploi(string $nomEmploi): self
    {
        $this->nomEmploi = $nomEmploi;

        return $this;
    }

    public function getDescriptionEmploi(): ?string
    {
        return $this->descriptionEmploi;
    }

    public function setDescriptionEmploi(string $descriptionEmploi): self
    {
        $this->descriptionEmploi = $descriptionEmploi;

        return $this;
    }

    public function getNbrOffres(): ?int
    {
        return $this->nbrOffres;
    }

    public function setNbrOffres(int $nbrOffres): self
    {
        $this->nbrOffres = $nbrOffres;

        return $this;
    }

    /**
     * @return Collection|OffreEmploi[]
     */
    public function getOffre(): Collection
    {
        return $this->offre;
    }

    public function addOffre(OffreEmploi $offre): self
    {
        if (!$this->offre->contains($offre)) {
            $this->offre[] = $offre;
            $offre->setCategorieEmploi($this);
        }

        return $this;
    }

    public function removeOffre(OffreEmploi $offre): self
    {
        if ($this->offre->removeElement($offre)) {
            // set the owning side to null (unless already changed)
            if ($offre->getCategorieEmploi() === $this) {
                $offre->setCategorieEmploi(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->nomEmploi;
    }
}
