<?php

namespace App\Entity;

use App\Repository\QuestionnaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuestionnaireRepository::class)
 */
class Questionnaire
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
    private $nom_qst;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_cat_qst;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $description_cat_qst;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbr_qst;

    /**
     * @ORM\ManyToOne(targetEntity="CategorieQuestionnaire" , inversedBy="questionnaire")
     * @ORM\JoinColumn(name="Categoriequestionnaire_id",referencedColumnName="id")
     */
    private $categorieQuestionnaire;

    /**
     * @return mixed
     */
    public function getCategorieQuestionnaire()
    {
        return $this->categorieQuestionnaire;
    }

    /**
     * @param mixed $categorieQuestionnaire
     */
    public function setCategorieQuestionnaire($categorieQuestionnaire): void
    {
        $this->categorieQuestionnaire = $categorieQuestionnaire;
    }

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="questionnaire_Id",cascade={"persist"})
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=Reponse::class, mappedBy="questionnaire",cascade={"remove"})
     */
    private $reponses;

    public function __construct()
    {
        $this->reponses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomQst(): ?string
    {
        return $this->nom_qst;
    }

    public function setNomQst(string $nom_qst): self
    {
        $this->nom_qst = $nom_qst;

        return $this;
    }

    public function getNomCatQst(): ?string
    {
        return $this->nom_cat_qst;
    }

    public function setNomCatQst(string $nom_cat_qst): self
    {
        $this->nom_cat_qst = $nom_cat_qst;

        return $this;
    }

    public function getDescriptionCatQst(): ?string
    {
        return $this->description_cat_qst;
    }

    public function setDescriptionCatQst(string $description_cat_qst): self
    {
        $this->description_cat_qst = $description_cat_qst;

        return $this;
    }

    public function getNbrQst(): ?int
    {
        return $this->nbr_qst;
    }

    public function setNbrQst(int $nbr_qst): self
    {
        $this->nbr_qst = $nbr_qst;

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
        return $this->nom_qst;
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
            $reponse->setQuestionnaire($this);
        }

        return $this;
    }

    public function removeReponse(Reponse $reponse): self
    {
        if ($this->reponses->removeElement($reponse)) {
            // set the owning side to null (unless already changed)
            if ($reponse->getQuestionnaire() === $this) {
                $reponse->setQuestionnaire(null);
            }
        }

        return $this;
    }
}
