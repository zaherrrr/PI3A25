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
     * @ORM\ManyToOne(targetEntity=CategoryFreelance::class, inversedBy="offreFreelances")
     */
    private $categorieFreelance;

    /**
     * @ORM\OneToMany(targetEntity=PostulerFreelance::class, mappedBy="offreFreelance",cascade={"remove"})
     */
    private $postulerFreelances;

    public function __construct()
    {
        $this->postulerFreelances = new ArrayCollection();
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

    public function getCategorieFreelance(): ?CategoryFreelance
    {
        return $this->categorieFreelance;
    }

    public function setCategorieFreelance(?CategoryFreelance $categorieFreelance): self
    {
        $this->categorieFreelance = $categorieFreelance;

        return $this;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|PostulerFreelance[]
     */
    public function getPostulerFreelances(): Collection
    {
        return $this->postulerFreelances;
    }

    public function addPostulerFreelance(PostulerFreelance $postulerFreelance): self
    {
        if (!$this->postulerFreelances->contains($postulerFreelance)) {
            $this->postulerFreelances[] = $postulerFreelance;
            $postulerFreelance->setOffreFreelance($this);
        }

        return $this;
    }

    public function removePostulerFreelance(PostulerFreelance $postulerFreelance): self
    {
        if ($this->postulerFreelances->removeElement($postulerFreelance)) {
            // set the owning side to null (unless already changed)
            if ($postulerFreelance->getOffreFreelance() === $this) {
                $postulerFreelance->setOffreFreelance(null);
            }
        }

        return $this;
    }

}
