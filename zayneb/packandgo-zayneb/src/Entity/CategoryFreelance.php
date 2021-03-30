<?php

namespace App\Entity;

use App\Repository\CategoryFreelanceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryFreelanceRepository::class)
 */
class CategoryFreelance
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
    private $nom_cat_fr;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description_cat_fr;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbr_offre_fr;

    /**
     * @ORM\OneToMany(targetEntity=OffreFreelance::class, mappedBy="categorieFreelance",cascade={"remove"})
     */
    private $offreFreelances;

    public function __construct()
    {
        $this->offreFreelances = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCatFr(): ?string
    {
        return $this->nom_cat_fr;
    }

    public function setNomCatFr(string $nom_cat_fr): self
    {
        $this->nom_cat_fr = $nom_cat_fr;

        return $this;
    }

    public function getDescriptionCatFr(): ?string
    {
        return $this->description_cat_fr;
    }

    public function setDescriptionCatFr(string $description_cat_fr): self
    {
        $this->description_cat_fr = $description_cat_fr;

        return $this;
    }

    public function getNbrOffreFr(): ?int
    {
        return $this->nbr_offre_fr;
    }

    public function setNbrOffreFr(int $nbr_offre_fr): self
    {
        $this->nbr_offre_fr = $nbr_offre_fr;

        return $this;
    }
    public function __toString()
    {
        return $this->nom_cat_fr;
    }

    /**
     * @return Collection|OffreFreelance[]
     */
    public function getOffreFreelances(): Collection
    {
        return $this->offreFreelances;
    }

    public function addOffreFreelance(OffreFreelance $offreFreelance): self
    {
        if (!$this->offreFreelances->contains($offreFreelance)) {
            $this->offreFreelances[] = $offreFreelance;
            $offreFreelance->setCategorieFreelance($this);
        }

        return $this;
    }

    public function removeOffreFreelance(OffreFreelance $offreFreelance): self
    {
        if ($this->offreFreelances->removeElement($offreFreelance)) {
            // set the owning side to null (unless already changed)
            if ($offreFreelance->getCategorieFreelance() === $this) {
                $offreFreelance->setCategorieFreelance(null);
            }
        }

        return $this;
    }
}
