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
     * @ORM\Column(type="datetime")
     */
    private $datePostulation;



    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="postulerFreelances")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $motivation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pdfcv;

    /**
     * @ORM\ManyToOne(targetEntity=OffreFreelance::class, inversedBy="postulerFreelances")
     */
    private $offreFreelance;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatePostulation(): ?\DateTimeInterface
    {
        return $this->datePostulation;
    }

    public function setDatePostulation(\DateTimeInterface $datePostulation): self
    {
        $this->datePostulation = $datePostulation;

        return $this;
    }



    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getMotivation(): ?string
    {
        return $this->motivation;
    }

    public function setMotivation(string $motivation): self
    {
        $this->motivation = $motivation;

        return $this;
    }

    public function getPdfcv(): ?string
    {
        return $this->pdfcv;
    }

    public function setPdfcv(string $pdfcv): self
    {
        $this->pdfcv = $pdfcv;

        return $this;
    }

    public function getOffreFreelance(): ?OffreFreelance
    {
        return $this->offreFreelance;
    }

    public function setOffreFreelance(?OffreFreelance $offreFreelance): self
    {
        $this->offreFreelance = $offreFreelance;

        return $this;
    }
}
