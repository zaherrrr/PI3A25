<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FormationRepository::class)
 */
class Formation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $duree_fr;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $niveau_frt;
    /**
     * @ORM\ManyToOne(targetEntity="CategorieFormation" , inversedBy="formation")
     * @ORM\JoinColumn(name="Categorieformation_id",referencedColumnName="id")
     */
    private $categorieFormation;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="formation_Id")
     */
    private $users;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDureeFr(): ?\DateTimeInterface
    {
        return $this->duree_fr;
    }

    public function setDureeFr(\DateTimeInterface $duree_fr): self
    {
        $this->duree_fr = $duree_fr;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getNiveauFrt(): ?string
    {
        return $this->niveau_frt;
    }

    public function setNiveauFrt(string $niveau_frt): self
    {
        $this->niveau_frt = $niveau_frt;

        return $this;
    }

    public function getCategorieFormation(): ?CategorieFormation
    {
        return $this->categorieFormation;
    }

    public function setCategorieFormation(?CategorieFormation $categorieFormation): self
    {
        $this->categorieFormation = $categorieFormation;

        return $this;
    }

    public function getUsers(): ?Users
    {
        return $this->users;
    }

    public function setUsers(?Users $users): self
    {
        $this->users = $users;

        return $this;
    }

    public function __toString()
    {
        return $this->niveau_frt;
    }
}
