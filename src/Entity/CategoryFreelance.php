<?php

namespace App\Entity;

use App\Repository\CategoryFreelanceRepository;
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
     * @ORM\OneToMany(targetEntity="OffreFreelance" , mappedBy="categorieFreelance")
     */
    private $offreFreelance ;

    /**
     * @return mixed
     */
    public function getOffreFreelance()
    {
        return $this->offreFreelance;
    }

    /**
     * @param mixed $offreFreelance
     */
    public function setOffreFreelance($offreFreelance): void
    {
        $this->offreFreelance = $offreFreelance;
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
}
