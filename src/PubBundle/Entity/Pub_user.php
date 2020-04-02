<?php

namespace PubBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pub_user
 *
 * @ORM\Table(name="pub_user")
 * @ORM\Entity(repositoryClass="PubBundle\Repository\Pub_userRepository")
 */
class Pub_user
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
     * @ORM\ManyToOne(targetEntity="Pub")
     * @ORM\JoinColumn(name="idPub", referencedColumnName="id",onDelete="CASCADE")
     **/
    private $idPub;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="idUser", referencedColumnName="id",onDelete="CASCADE")
     **/
    private $idUser;

    /**
     * @var int
     *
     * @ORM\Column(name="durre", type="integer",nullable=true)
     */
    private $durre;


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
     * Set idPub
     *
     * @param integer $idPub
     *
     * @return Pub_user
     */
    public function setIdPub($idPub)
    {
        $this->idPub = $idPub;
    
        return $this;
    }

    /**
     * Get idPub
     *
     * @return integer
     */
    public function getIdPub()
    {
        return $this->idPub;
    }

    /**
     * Set idUser
     *
     * @param string $idUser
     *
     * @return Pub_user
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    
        return $this;
    }

    /**
     * Get idUser
     *
     * @return string
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set durre
     *
     * @param integer $durre
     *
     * @return Pub_user
     */
    public function setDurre($durre)
    {
        $this->durre = $durre;
    
        return $this;
    }

    /**
     * Get durre
     *
     * @return integer
     */
    public function getDurre()
    {
        return $this->durre;
    }
}

