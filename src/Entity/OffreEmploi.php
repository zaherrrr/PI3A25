<?php

namespace App\Entity;

use App\Repository\OffreEmploiRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OffreEmploiRepository::class)
 */
class OffreEmploi
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
    private $titre_offre_emploi;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description_cat_em;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbr_offres;
    /**
     * @ORM\ManyToOne(targetEntity="CategorieEmploi" , inversedBy="offre")
     * @ORM\JoinColumn(name="CategorieEmploi_id",referencedColumnName="id")
     */
    private $categorieEmploi;

    /**
    @ORM\OneToMany(targetEntity=PostulerEmploi::class, mappedBy="offreEmploi")
     */
    private $Pos;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreOffreEmploi(): ?string
    {
        return $this->titre_offre_emploi;
    }

    public function setTitreOffreEmploi(string $titre_offre_emploi): self
    {
        $this->titre_offre_emploi = $titre_offre_emploi;

        return $this;
    }

    public function getDescriptionCatEm(): ?string
    {
        return $this->description_cat_em;
    }

    public function setDescriptionCatEm(string $description_cat_em): self
    {
        $this->description_cat_em = $description_cat_em;

        return $this;
    }

    public function getNbrOffres(): ?int
    {
        return $this->nbr_offres;
    }

    public function setNbrOffres(int $nbr_offres): self
    {
        $this->nbr_offres = $nbr_offres;

        return $this;
    }

    public function getCategorieEmploi(): ?CategorieEmploi
    {
        return $this->categorieEmploi;
    }

    public function setCategorieEmploi(?CategorieEmploi $categorieEmploi): self
    {
        $this->categorieEmploi = $categorieEmploi;

        return $this;
    }

    public function getPos(): ?PostulerEmploi
    {
        return $this->Pos;
    }

    public function setPos(?PostulerEmploi $Pos): self
    {
        $this->Pos = $Pos;

        return $this;
    }

    public function __toString()
    {
        return $this->titre_offre_emploi;
    }
}
