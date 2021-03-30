<?php

namespace App\Entity;

use App\Repository\PostulerEmploiRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PostulerEmploiRepository::class)
 */
class PostulerEmploi
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
    private $datePostulation;

    /**
     * @ORM\ManyToOne(targetEntity=OffreEmploi::class, inversedBy="postulerEmplois")
     */
    private $offreEmploi;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="postulerEmplois")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $motivation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Please, upload a pdf file.")
     * @Assert\File
     */
    private $pdfcv;






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

    public function getOffreEmploi(): ?OffreEmploi
    {
        return $this->offreEmploi;
    }

    public function setOffreEmploi(?OffreEmploi $offreEmploi): self
    {
        $this->offreEmploi = $offreEmploi;

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

    public function getMotivation()
    {
        return $this->motivation;
    }

    public function setMotivation(string $motivation): self
    {
        $this->motivation = $motivation;

        return $this;
    }

    public function getPdfcv()
    {
        return $this->pdfcv;
    }

    public function setPdfcv(string $pdfcv)
    {
        $this->pdfcv = $pdfcv;

        return $this;
    }



}
