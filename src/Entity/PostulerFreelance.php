<?php

namespace App\Entity;

use App\Repository\PostulerFreelanceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PostulerFreelanceRepository::class)
 */
class PostulerFreelance
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date_postulation_fr;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $etat_postulation_fr;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="postulerFeelance_id")
     * @ORM\JoinColumn(nullable=false)
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity=OffreFreelance::class, inversedBy="type")
     * @ORM\JoinColumn(name="OffreFreelance_Id",referencedColumnName="id")
     */
    private $postulerFreelance;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatePostulationFr(): ?\DateTimeInterface
    {
        return $this->date_postulation_fr;
    }

    public function setDatePostulationFr(\DateTimeInterface $date_postulation_fr): self
    {
        $this->date_postulation_fr = $date_postulation_fr;

        return $this;
    }

    public function getEtatPostulationFr(): ?string
    {
        return $this->etat_postulation_fr;
    }

    public function setEtatPostulationFr(string $etat_postulation_fr): self
    {
        $this->etat_postulation_fr = $etat_postulation_fr;

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


}
