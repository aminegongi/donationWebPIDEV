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
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     **/
    private $idUser;

    /**
     * @ORM\ManyToOne(targetEntity="AideBundle\Entity\DemandeAide")
     * @ORM\JoinColumn(name="id_demande", referencedColumnName="id")
     **/
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

