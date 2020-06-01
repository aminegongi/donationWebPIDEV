<?php

namespace AideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DemandeAide
 *
 * @ORM\Table(name="demande_aide")
 * @ORM\Entity(repositoryClass="AideBundle\Repository\DemandeAideRepository")
 */
class DemandeAide
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
     * @ORM\ManyToOne(targetEntity="AideBundle\Entity\CategorieAide")
     * @ORM\JoinColumn(name="id_categorie", referencedColumnName="id")
     **/
    private $idCategorie;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     **/
    private $idUser;

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
     * @ORM\Column(name="etat", type="string", length=255)
     */
    private $etat;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_reactions", type="integer")
     */
    private $nbReactions;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=255, nullable=true)
     */
    private $photo;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idCategorie
     *
     * @param integer $idCategorie
     *
     * @return DemandeAide
     */
    public function setIdCategorie($idCategorie)
    {
        $this->idCategorie = $idCategorie;
    
        return $this;
    }

    /**
     * Get idCategorie
     *
     * @return integer
     */
    public function getIdCategorie()
    {
        return $this->idCategorie;
    }

    /**
     * Set idUser
     *
     * @param integer $idUser
     *
     * @return DemandeAide
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    
        return $this;
    }

    /**
     * Get idUser
     *
     * @return integer
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return DemandeAide
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
     * @return DemandeAide
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
     * Set etat
     *
     * @param string $etat
     *
     * @return DemandeAide
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    
        return $this;
    }

    /**
     * Get etat
     *
     * @return string
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set nbReactions
     *
     * @param integer $nbReactions
     *
     * @return DemandeAide
     */
    public function setNbReactions($nbReactions)
    {
        $this->nbReactions = $nbReactions;
    
        return $this;
    }

    /**
     * Get nbReactions
     *
     * @return integer
     */
    public function getNbReactions()
    {
        return $this->nbReactions;
    }

    /**
     * Set photo
     *
     * @param string $photo
     *
     * @return DemandeAide
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

    public function __toString() {
        return $this->titre;
    }

}

