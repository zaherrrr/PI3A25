<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert ;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity ;


/**
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 * @Vich\Uploadable
 * @UniqueEntity(
 *     fields = {"username"},
 *     message="le username existe deja"
 * )
 */
class Users implements UserInterface
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

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
     * @Assert\Email()
     */
    private $email;

    /**
     * @Assert\Length(min=5,max=10,minMessage="il faut au moin 5 carac",maxMessage="il faut au max 10 carac")
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**

     * @ORM\Column(type="string", length=255)
     */
    private $password;


    /**
     * @Assert\EqualTo(propertyPath="password",message="les mdp ne correspondent pas")
     */
    private $verifpassword ;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $roles;

    /**
     * @ORM\OneToMany(targetEntity=PostulerEmploi::class, mappedBy="user",cascade={"remove"})
     */
    private $postulerEmplois;

    /**
     * @ORM\OneToMany(targetEntity=Reponse::class, mappedBy="user",cascade={"remove"})
     */
    private $reponses;

    /**
     * @ORM\OneToMany(targetEntity=PostulerFreelance::class, mappedBy="user",cascade={"remove"})
     */
    private $postulerFreelances;

    /**
     * @ORM\OneToMany(targetEntity=ParticerFormation::class, mappedBy="user",cascade={"remove"})
     */
    private $particerFormations;

    /**
     * @ORM\OneToMany(targetEntity=Reclamation::class, mappedBy="user")
     */
    private $reclamations;



    public function __construct()
    {
        $this->postulerEmplois = new ArrayCollection();
        $this->reponses = new ArrayCollection();
        $this->postulerFreelances = new ArrayCollection();
        $this->particerFormations = new ArrayCollection();
        $this->reclamations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getVerifpassword(): ?string
    {
        return $this->verifpassword;
    }

    public function setVerifpassword(string $verifpassword): self
    {
        $this->verifpassword = $verifpassword;

        return $this;
    }

    public function getRoles()
    {
        return [$this->roles];
    }

    public function setRoles(?string $roles): self
    {
        $this->roles = $roles;

        return $this;
    }


    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getSalt()
    {
        return $this->email;
        // TODO: Implement getSalt() method.
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

    /**
     * @return Collection|PostulerEmploi[]
     */
    public function getPostulerEmplois(): Collection
    {
        return $this->postulerEmplois;
    }

    public function addPostulerEmploi(PostulerEmploi $postulerEmploi): self
    {
        if (!$this->postulerEmplois->contains($postulerEmploi)) {
            $this->postulerEmplois[] = $postulerEmploi;
            $postulerEmploi->setUser($this);
        }

        return $this;
    }

    public function removePostulerEmploi(PostulerEmploi $postulerEmploi): self
    {
        if ($this->postulerEmplois->removeElement($postulerEmploi)) {
            // set the owning side to null (unless already changed)
            if ($postulerEmploi->getUser() === $this) {
                $postulerEmploi->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Reponse[]
     */
    public function getReponses(): Collection
    {
        return $this->reponses;
    }

    public function addReponse(Reponse $reponse): self
    {
        if (!$this->reponses->contains($reponse)) {
            $this->reponses[] = $reponse;
            $reponse->setUser($this);
        }

        return $this;
    }

    public function removeReponse(Reponse $reponse): self
    {
        if ($this->reponses->removeElement($reponse)) {
            // set the owning side to null (unless already changed)
            if ($reponse->getUser() === $this) {
                $reponse->setUser(null);
            }
        }

        return $this;
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
            $postulerFreelance->setUser($this);
        }

        return $this;
    }

    public function removePostulerFreelance(PostulerFreelance $postulerFreelance): self
    {
        if ($this->postulerFreelances->removeElement($postulerFreelance)) {
            // set the owning side to null (unless already changed)
            if ($postulerFreelance->getUser() === $this) {
                $postulerFreelance->setUser(null);
            }
        }

        return $this;
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
            $particerFormation->setUser($this);
        }

        return $this;
    }

    public function removeParticerFormation(ParticerFormation $particerFormation): self
    {
        if ($this->particerFormations->removeElement($particerFormation)) {
            // set the owning side to null (unless already changed)
            if ($particerFormation->getUser() === $this) {
                $particerFormation->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Reclamation[]
     */
    public function getReclamations(): Collection
    {
        return $this->reclamations;
    }

    public function addReclamation(Reclamation $reclamation): self
    {
        if (!$this->reclamations->contains($reclamation)) {
            $this->reclamations[] = $reclamation;
            $reclamation->setUser($this);
        }

        return $this;
    }

    public function removeReclamation(Reclamation $reclamation): self
    {
        if ($this->reclamations->removeElement($reclamation)) {
            // set the owning side to null (unless already changed)
            if ($reclamation->getUser() === $this) {
                $reclamation->setUser(null);
            }
        }

        return $this;
    }


}
