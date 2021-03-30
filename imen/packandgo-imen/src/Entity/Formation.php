<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=FormationRepository::class)
 * @Vich\Uploadable
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
    private $image;

    /**
     * @Vich\UploadableField(mapping="utilisateur_image", fileNameProperty="image")
     */
    private $imageFile ;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $niveau_frt;
    /**
     * @ORM\ManyToOne(targetEntity="CategorieFormation" , inversedBy="formation",cascade={"remove"})
     * @ORM\JoinColumn(name="Categorieformation_id",referencedColumnName="id",onDelete="CASCADE")
     */
    private $categorieFormation;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="formation_Id",cascade={"persist"})
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=ParticerFormation::class, mappedBy="formation",cascade={"remove"})
     */
    private $particerFormations;

    public function __construct()
    {
        $this->particerFormations = new ArrayCollection();
        $this->duree_fr=new \DateTime();
    }

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
    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

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
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }


    public function setImageFile(?File $imageFile = null): self
    {
        $this->imageFile = $imageFile;
        return $this ;

        //if (null !== $imageFile) {
        // It is required that at least one field changes if you are using doctrine
        // otherwise the event listeners won't be called and the file is lost
        //$this->updatedAt = new \DateTimeImmutable();
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

    /**
     * @return Collection|ParticerFormation[]
     */
    public function getParticerFormations(): Collection
    {
        return $this->particerFormations;
    }

    public function addParticerFormation(ParticerFormation $particerFormation): self
    {
        if (!$this->particerFormations->contains($particerFormation)) {
            $this->particerFormations[] = $particerFormation;
            $particerFormation->setFormation($this);
        }

        return $this;
    }

    public function removeParticerFormation(ParticerFormation $particerFormation): self
    {
        if ($this->particerFormations->removeElement($particerFormation)) {
            // set the owning side to null (unless already changed)
            if ($particerFormation->getFormation() === $this) {
                $particerFormation->setFormation(null);
            }
        }

        return $this;
    }
}
