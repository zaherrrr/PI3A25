<?php

namespace App\Entity;

use App\Repository\CategorieQuestionnaireRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategorieQuestionnaireRepository::class)
 */
class CategorieQuestionnaire
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
    private $nom_cat_qst;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description_cat_qst;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbr_qst;

   /**
    * @ORM\OneToMany(targetEntity="Questionnaire" , mappedBy="categorieQuestionnaire")
    */
    private $questionnaire;

    /**
     * @return mixed
     */
    public function getQuestionnaire()
    {
        return $this->questionnaire;
    }

    /**
     * @param mixed $questionnaire
     */
    public function setQuestionnaire($questionnaire): void
    {
        $this->questionnaire = $questionnaire;
    }
    public function getId(): ?int
    {
        return $this->id;
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
    public function __toString()
    {
        return $this->nom_cat_qst;
    }
}
