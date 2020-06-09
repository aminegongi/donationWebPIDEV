<?php

namespace EmploiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Emplois
 *
 * @ORM\Table(name="emplois")
 * @ORM\Entity(repositoryClass="EmploiBundle\Repository\EmploisRepository")
 */
class Emplois
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="Photo", type="string", length=255)
     */
    private $photo;

    /**
     * @var float
     *
     * @ORM\Column(name="salaire", type="float")
     */
    private $salaire;

    /**
     * @var string
     *
     * @ORM\Column(name="emplacement", type="string", length=255)
     */
    private $emplacement;

    /**
     * @var string
     *
     * @ORM\Column(name="TypeDemploi", type="string", length=255)
     */
    private $typeDemploi;

    /**
     * @var string
     *
     * @ORM\Column(name="TypeContrat", type="string", length=255)
     */
    private $typeContrat;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="id_utilisateur", referencedColumnName="id")
     */
    private $id_utilisateur;
    /**
     * @ORM\ManyToOne(targetEntity="CategorieEmploi")
     * @ORM\JoinColumn(name="idcategorie", referencedColumnName="id" , onDelete="CASCADE")
     */
    private $idcategorie;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Emplois
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Emplois
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set photo
     *
     * @param string $photo
     *
     * @return Emplois
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set salaire
     *
     * @param float $salaire
     *
     * @return Emplois
     */
    public function setSalaire($salaire)
    {
        $this->salaire = $salaire;

        return $this;
    }

    /**
     * Get salaire
     *
     * @return float
     */
    public function getSalaire()
    {
        return $this->salaire;
    }

    /**
     * Set emplacement
     *
     * @param string $emplacement
     *
     * @return Emplois
     */
    public function setEmplacement($emplacement)
    {
        $this->emplacement = $emplacement;

        return $this;
    }

    /**
     * Get emplacement
     *
     * @return string
     */
    public function getEmplacement()
    {
        return $this->emplacement;
    }

    /**
     * Set typeDemploi
     *
     * @param string $typeDemploi
     *
     * @return Emplois
     */
    public function setTypeDemploi($typeDemploi)
    {
        $this->typeDemploi = $typeDemploi;

        return $this;
    }

    /**
     * Get typeDemploi
     *
     * @return string
     */
    public function getTypeDemploi()
    {
        return $this->typeDemploi;
    }

    /**
     * Set typeContrat
     *
     * @param string $typeContrat
     *
     * @return Emplois
     */
    public function setTypeContrat($typeContrat)
    {
        $this->typeContrat = $typeContrat;

        return $this;
    }

    /**
     * Get typeContrat
     *
     * @return string
     */
    public function getTypeContrat()
    {
        return $this->typeContrat;
    }

    /**
     * Set idUtilisateur
     *
     * @param \UserBundle\Entity\User $idUtilisateur
     *
     * @return Emplois
     */
    public function setIdUtilisateur(\UserBundle\Entity\User $idUtilisateur = null)
    {
        $this->id_utilisateur = $idUtilisateur;

        return $this;
    }

    /**
     * Get idUtilisateur
     *
     * @return \UserBundle\Entity\User
     */
    public function getIdUtilisateur()
    {
        return $this->id_utilisateur;
    }

    /**
     * Set idcategorie
     *
     * @param \EmploiBundle\Entity\CategorieEmploi $idcategorie
     *
     * @return Emplois
     */
    public function setIdcategorie(\EmploiBundle\Entity\CategorieEmploi $idcategorie = null)
    {
        $this->idcategorie = $idcategorie;

        return $this;
    }

    /**
     * Get idcategorie
     *
     * @return \EmploiBundle\Entity\CategorieEmploi
     */
    public function getIdcategorie()
    {
        return $this->idcategorie;
    }
}
