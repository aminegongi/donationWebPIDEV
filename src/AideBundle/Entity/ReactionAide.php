<?php

namespace AideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReactionAide
 *
 * @ORM\Table(name="reaction_aide")
 * @ORM\Entity(repositoryClass="AideBundle\Repository\ReactionAideRepository")
 */
class ReactionAide
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
     * @ORM\Column(name="id_user", type="integer")
     */
    private $idUser;

    /**
     * @var int
     *
     * @ORM\Column(name="id_demande", type="integer")
     */
    private $idDemande;


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
     * Set idUser
     *
     * @param integer $idUser
     *
     * @return ReactionAide
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
     * Set idDemande
     *
     * @param integer $idDemande
     *
     * @return ReactionAide
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
}

