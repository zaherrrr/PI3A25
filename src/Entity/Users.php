<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
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
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=PostulerEmploi::class, mappedBy="user")
     */
    private $relation;

    /**
     * @ORM\OneToMany(targetEntity=PostulerFreelance::class, mappedBy="users")
     */
    private $postulerFeelance_id;

    /**
     * @ORM\OneToMany(targetEntity=Formation::class, mappedBy="users")
     */
    private $formation_Id;

    /**
     * @ORM\OneToMany(targetEntity=Questionnaire::class, mappedBy="users")
     */
    private $questionnaire_Id;

    /**
     * @ORM\OneToMany(targetEntity=Contact::class, mappedBy="users")
     */
    private $contact_Id;

    public function __construct()
    {
        $this->relation = new ArrayCollection();
        $this->postulerFeelance_id = new ArrayCollection();
        $this->formation_Id = new ArrayCollection();
        $this->questionnaire_Id = new ArrayCollection();
        $this->contact_Id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|PostulerEmploi[]
     */
    public function getRelation(): Collection
    {
        return $this->relation;
    }

    public function addRelation(PostulerEmploi $relation): self
    {
        if (!$this->relation->contains($relation)) {
            $this->relation[] = $relation;
            $relation->setPostulerEmploi($this);
        }

        return $this;
    }

    public function removeRelation(PostulerEmploi $relation): self
    {
        if ($this->relation->removeElement($relation)) {
            // set the owning side to null (unless already changed)
            if ($relation->getPostulerEmploi() === $this) {
                $relation->setPostulerEmploi(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PostulerFreelance[]
     */
    public function getPostulerFeelanceId(): Collection
    {
        return $this->postulerFeelance_id;
    }

    public function addPostulerFeelanceId(PostulerFreelance $postulerFeelanceId): self
    {
        if (!$this->postulerFeelance_id->contains($postulerFeelanceId)) {
            $this->postulerFeelance_id[] = $postulerFeelanceId;
            $postulerFeelanceId->setUsers($this);
        }

        return $this;
    }

    public function removePostulerFeelanceId(PostulerFreelance $postulerFeelanceId): self
    {
        if ($this->postulerFeelance_id->removeElement($postulerFeelanceId)) {
            // set the owning side to null (unless already changed)
            if ($postulerFeelanceId->getUsers() === $this) {
                $postulerFeelanceId->setUsers(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Formation[]
     */
    public function getFormationId(): Collection
    {
        return $this->formation_Id;
    }

    public function addFormationId(Formation $formationId): self
    {
        if (!$this->formation_Id->contains($formationId)) {
            $this->formation_Id[] = $formationId;
            $formationId->setUsers($this);
        }

        return $this;
    }

    public function removeFormationId(Formation $formationId): self
    {
        if ($this->formation_Id->removeElement($formationId)) {
            // set the owning side to null (unless already changed)
            if ($formationId->getUsers() === $this) {
                $formationId->setUsers(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Questionnaire[]
     */
    public function getQuestionnaireId(): Collection
    {
        return $this->questionnaire_Id;
    }

    public function addQuestionnaireId(Questionnaire $questionnaireId): self
    {
        if (!$this->questionnaire_Id->contains($questionnaireId)) {
            $this->questionnaire_Id[] = $questionnaireId;
            $questionnaireId->setUsers($this);
        }

        return $this;
    }

    public function removeQuestionnaireId(Questionnaire $questionnaireId): self
    {
        if ($this->questionnaire_Id->removeElement($questionnaireId)) {
            // set the owning side to null (unless already changed)
            if ($questionnaireId->getUsers() === $this) {
                $questionnaireId->setUsers(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Contact[]
     */
    public function getContactId(): Collection
    {
        return $this->contact_Id;
    }

    public function addContactId(Contact $contactId): self
    {
        if (!$this->contact_Id->contains($contactId)) {
            $this->contact_Id[] = $contactId;
            $contactId->setUsers($this);
        }

        return $this;
    }

    public function removeContactId(Contact $contactId): self
    {
        if ($this->contact_Id->removeElement($contactId)) {
            // set the owning side to null (unless already changed)
            if ($contactId->getUsers() === $this) {
                $contactId->setUsers(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->email;
    }
}
