<?php

namespace RestoDonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DonRestaurant
 *
 * @ORM\Table(name="don_restaurant")
 * @ORM\Entity(repositoryClass="RestoDonBundle\Repository\DonRestaurantRepository")
 */
class DonRestaurant
{
    /**
     * @var int
     *
     * @ORM\Column(name="idDon", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idDon;


    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="idResto", referencedColumnName="id")
     **/
    private $idResto;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="idUser", referencedColumnName="id")
     **/
    private $idUser;

    /**
     * @var string
     *
     * @ORM\Column(name="montant", type="decimal", precision=9, scale=3)
     */
    private $montant;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;


    /**
     * Get idDon
     *
     * @return int
     */
    public function getIdDon()
    {
        return $this->idDon;
    }

    /**
     * @param mixed $idResto
     */
    public function setIdResto($idResto)
    {
        $this->idResto = $idResto;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdResto()
    {
        return $this->idResto;
    }

    /**
     * @param mixed $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set montant
     *
     * @param string $montant
     *
     * @return DonRestaurant
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get montant
     *
     * @return string
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return DonRestaurant
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
}

