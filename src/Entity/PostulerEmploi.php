<?php

namespace App\Entity;

use App\Repository\PostulerEmploiRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\ManyToOne(targetEntity=OffreEmploi::class, inversedBy="type")
     * @ORM\JoinColumn(name="OffrePostulation_Id",referencedColumnName="id")
     */
    private $offreEmploi;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="relation")
     * @ORM\JoinColumn(name="userid",referencedColumnName="id")
     */
    private $user;

    public function __construct()
    {
        $this->type = new ArrayCollection();
    }

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

    public function getOffreEmploi(): ?string
    {
        return $this->offreEmploi;
    }

    public function setOffreEmploi(?string $offreEmploi): self
    {
        $this->offreEmploi = $offreEmploi;

        return $this;
    }

    /**
     * @return Collection|OffreEmploi[]
     */
    public function getType(): Collection
    {
        return $this->type;
    }

    public function addType(OffreEmploi $type): self
    {
        if (!$this->type->contains($type)) {
            $this->type[] = $type;
            $type->setPos($this);
        }

        return $this;
    }

    public function removeType(OffreEmploi $type): self
    {
        if ($this->type->removeElement($type)) {
            // set the owning side to null (unless already changed)
            if ($type->getPos() === $this) {
                $type->setPos(null);
            }
        }

        return $this;
    }

    public function getPostulerEmploi(): ?Users
    {
        return $this->postulerEmploi;
    }

    public function setPostulerEmploi(?Users $postulerEmploi): self
    {
        $this->postulerEmploi = $postulerEmploi;

        return $this;
    }


}
