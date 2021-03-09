<?php

namespace App\Entity;

use App\Repository\OffreFreelanceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OffreFreelanceRepository::class)
 */
class OffreFreelance
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
    private $titre_offre_fr;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descriptionfr;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $entreprisefr;

    /**
     * @ORM\Column(type="float")
     */
    private $recomponse;

    /**
     * @ORM\Column(type="date")
     */
    private $date_expiration;

    /**
     * @ORM\Column(type="boolean")
     */
    private $etat_offre;


    /**
     * @ORM\ManyToOne(targetEntity="CategoryFreelance" , inversedBy="offreFreelance")
     * @ORM\JoinColumn(name="Categoriefreelance_id",referencedColumnName="id")
     */
    private $categorieFreelance;

    /**
     * @return mixed
     */
    public function getCategorieFreelance()
    {
        return $this->categorieFreelance;
    }

    /**
     * @param mixed $categorieFreelance
     */
    public function setCategorieFreelance($categorieFreelance): void
    {
        $this->categorieFreelance = $categorieFreelance;
    }



    /**
     * @ORM\OneToMany(targetEntity=OffreFreelance::class, mappedBy="relation")
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

    public function getTitreOffreFr(): ?string
    {
        return $this->titre_offre_fr;
    }

    public function setTitreOffreFr(string $titre_offre_fr): self
    {
        $this->titre_offre_fr = $titre_offre_fr;

        return $this;
    }

    public function getDescriptionfr(): ?string
    {
        return $this->descriptionfr;
    }

    public function setDescriptionfr(string $descriptionfr): self
    {
        $this->descriptionfr = $descriptionfr;

        return $this;
    }

    public function getEntreprisefr(): ?string
    {
        return $this->entreprisefr;
    }

    public function setEntreprisefr(string $entreprisefr): self
    {
        $this->entreprisefr = $entreprisefr;

        return $this;
    }

    public function getRecomponse(): ?float
    {
        return $this->recomponse;
    }

    public function setRecomponse(float $recomponse): self
    {
        $this->recomponse = $recomponse;

        return $this;
    }

    public function getDateExpiration(): ?\DateTimeInterface
    {
        return $this->date_expiration;
    }

    public function setDateExpiration(\DateTimeInterface $date_expiration): self
    {
        $this->date_expiration = $date_expiration;

        return $this;
    }

    public function getEtatOffre(): ?bool
    {
        return $this->etat_offre;
    }

    public function setEtatOffre(bool $etat_offre): self
    {
        $this->etat_offre = $etat_offre;

        return $this;
    }

    public function getRelation(): ?self
    {
        return $this->relation;
    }

    public function setRelation(?self $relation): self
    {
        $this->relation = $relation;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getOffreFreelances(): Collection
    {
        return $this->offreFreelances;
    }

    public function addOffreFreelance(self $offreFreelance): self
    {
        if (!$this->offreFreelances->contains($offreFreelance)) {
            $this->offreFreelances[] = $offreFreelance;
            $offreFreelance->setRelation($this);
        }

        return $this;
    }

    public function removeOffreFreelance(self $offreFreelance): self
    {
        if ($this->offreFreelances->removeElement($offreFreelance)) {
            // set the owning side to null (unless already changed)
            if ($offreFreelance->getRelation() === $this) {
                $offreFreelance->setRelation(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->titre_offre_fr;
    }
}
