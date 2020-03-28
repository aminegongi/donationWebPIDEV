<?php

namespace AideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SignalementAide
 *
 * @ORM\Table(name="signalement_aide")
 * @ORM\Entity(repositoryClass="AideBundle\Repository\SignalementAideRepository")
 */
class SignalementAide
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
     * @var int
     *
     * @ORM\Column(name="id_demande", type="integer")
     */
    private $idDemande;

    /**
     * @var int
     *
     * @ORM\Column(name="id_user", type="integer")
     */
    private $idUser;

    /**
     * @var string
     *
     * @ORM\Column(name="raison", type="string", length=255)
     */
    private $raison;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;


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
     * Set idDemande
     *
     * @param integer $idDemande
     *
     * @return SignalementAide
     */
    public function setIdDemande($idDemande)
    {
        $this->idDemande = $idDemande;
    
        return $this;
    }

    /**
     * Get idDemande
     *
     * @return integer
     */
    public function getIdDemande()
    {
        return $this->idDemande;
    }

    /**
     * Set idUser
     *
     * @param integer $idUser
     *
     * @return SignalementAide
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
     * Set raison
     *
     * @param string $raison
     *
     * @return SignalementAide
     */
    public function setRaison($raison)
    {
        $this->raison = $raison;
    
        return $this;
    }

    /**
     * Get raison
     *
     * @return string
     */
    public function getRaison()
    {
        return $this->raison;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return SignalementAide
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
}

